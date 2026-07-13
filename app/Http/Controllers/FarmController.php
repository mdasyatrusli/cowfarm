<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFarmRequest;
use App\Http\Requests\UpdateFarmRequest;
use App\Models\Farm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FarmController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Farm::class, 'farm');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $farms = Farm::withCount('users', 'cows')
            ->with('owner')
            ->paginate(10);

        return view('farms.index', compact('farms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('farms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFarmRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = Auth::user();

        // An admin_farm creating a farm (without picking an owner) becomes the
        // owner of that farm and gets farm_id set automatically. Super admin
        // may optionally pick an owner via the validated owner_id field.
        if (! $user->isSuperAdmin() && is_null($user->farm_id)) {
            $validated['owner_id'] = $user->id;
        }

        return DB::transaction(function () use ($validated) {
            $farm = Farm::create($validated);

            // Link the chosen owner to the newly created farm.
            if (! empty($validated['owner_id'])) {
                $owner = User::findOrFail($validated['owner_id']);

                // Server-side guard: Super Admin is a global role and must never
                // be bound to a single farm (would break isSuperAdmin()/global
                // scope bypass that relies on farm_id being null).
                if ($owner->isSuperAdmin()) {
                    abort(422, 'A Super Admin cannot be assigned as a farm owner.');
                }

                // Server-side guard: only allow owners without an existing farm
                // (prevents race conditions or tampered requests from
                // reassigning a user that already belongs to another farm).
                if (! is_null($owner->farm_id)) {
                    abort(422, 'The selected owner is already assigned to another farm.');
                }

                $owner->update(['farm_id' => $farm->id]);
            }

            return redirect()->route('farms.index')
                ->with('success', 'Farm created successfully.');
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Farm $farm): View
    {
        return view('farms.edit', compact('farm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFarmRequest $request, Farm $farm): RedirectResponse
    {
        $validated = $request->validated();

        $farm->update($validated);

        // Super admin may return to the full farm list. An admin_farm is only
        // allowed to manage their own farm, so redirect them to "My Farm"
        // instead of the index (which is restricted to super_admin via
        // FarmPolicy::viewAny and would otherwise yield a 403 on redirect).
        if (Auth::user()->isSuperAdmin()) {
            return redirect()->route('farms.index')
                ->with('success', 'Farm updated successfully.');
        }

        return redirect()->route('my-farm')
            ->with('success', 'Farm updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farm $farm): RedirectResponse
    {
        $farm->delete();

        return redirect()->route('farms.index')
            ->with('success', 'Farm deleted successfully.');
    }

    /**
     * Display the current user's farm (for admin_farm role).
     */
    public function myFarm(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->farm_id) {
            abort(404, 'You are not assigned to any farm.');
        }

        $farm = Farm::withCount('users', 'cows')
            ->with(['owner', 'cows', 'users'])
            ->findOrFail($user->farm_id);

        return view('farms.edit', compact('farm'));
    }
}
