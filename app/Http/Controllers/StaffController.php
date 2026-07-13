<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get all staff (role 'user') for this admin's farm
        $staff = User::where('farm_id', $user->farm_id)
            ->where('role', User::ROLE_USER)
            ->orderBy('name')
            ->paginate(10);

        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = $request->user();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_USER,
            'farm_id' => $admin->farm_id,
            'is_active' => true,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(User $staff)
    {
        $this->authorize('update', $staff);

        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, User $staff)
    {
        $this->authorize('update', $staff);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$staff->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $staff->name = $request->name;
        $staff->email = $request->email;

        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->save();

        return redirect()->route('staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }

    /**
     * Toggle the active status of the specified staff member.
     */
    public function toggleStatus(User $staff)
    {
        $this->authorize('toggleStatus', $staff);

        $staff->is_active = !$staff->is_active;
        $staff->save();

        $statusMessage = $staff->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('staff.index')->with('success', "Akun staff berhasil {$statusMessage}.");
    }
}
