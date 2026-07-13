<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCowRequest;
use App\Http\Requests\UpdateCowRequest;
use App\Models\Cow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CowController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Cow::class, 'cow');
    }

    /**
     * Display a listing of the cows.
     */
    public function index(): View
    {
        $cows = Cow::with('farm')
            ->latest()
            ->paginate(15);

        return view('cows.index', compact('cows'));
    }

    /**
     * Show the form for creating a new cow.
     */
    public function create(): View
    {
        return view('cows.create');
    }

    /**
     * Store a newly created cow in storage.
     */
    public function store(StoreCowRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Cow::create($validated);

        return redirect()->route('cows.index')
            ->with('success', 'Cow created successfully.');
    }

    /**
     * Show the form for editing the specified cow.
     */
    public function edit(Cow $cow): View
    {
        return view('cows.edit', compact('cow'));
    }

    /**
     * Update the specified cow in storage.
     */
    public function update(UpdateCowRequest $request, Cow $cow): RedirectResponse
    {
        $validated = $request->validated();

        $cow->update($validated);

        return redirect()->route('cows.index')
            ->with('success', 'Cow updated successfully.');
    }

    /**
     * Remove the specified cow from storage.
     */
    public function destroy(Cow $cow): RedirectResponse
    {
        $cow->delete();

        return redirect()->route('cows.index')
            ->with('success', 'Cow deleted successfully.');
    }
}
