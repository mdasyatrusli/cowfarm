<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['sometimes', 'string', new In([User::ROLE_ADMIN_FARM, User::ROLE_WORKER])],
        ]);

        return DB::transaction(function () use ($request) {
            $role = $request->role ?? User::ROLE_ADMIN_FARM;

            if ($role === User::ROLE_WORKER) {
                // Worker registration does not create a farm
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => User::ROLE_WORKER,
                    'farm_id' => null,
                ]);
            } else {
                // Create a new farm for the registering user (admin_farm)
                $farm = Farm::create([
                    'name' => $request->name . "'s Farm",
                    'location' => '',
                    'owner_id' => null, // Will be updated after user is created
                ]);

                // Create the user as admin_farm of that farm
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => User::ROLE_ADMIN_FARM,
                    'farm_id' => $farm->id,
                ]);

                // Set the owner of the farm
                $farm->update(['owner_id' => $user->id]);
            }

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        });
    }
}
