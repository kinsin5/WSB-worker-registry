<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['employee','supervisor'])]
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);


        return redirect()
            ->route('dashboard.admin')
            ->with('status', 'Użytkownik został utworzony.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'exists:users,id']
        ]);

        User::where('id', $validated['id'])->delete();

        return redirect()
            ->route('dashboard.admin')
            ->with('status', "Uzytkownik zostal usuniety");
    }

    public function edit(User $user): View
    {
        return view('adminLte.edit', 
        compact('user'));
    }

    public function update(Request $request, User $user) : RedirectResponse
    {
 
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['employee','supervisor'])]
        ]);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        return redirect()
            ->route('dashboard.admin')
            ->with('status', 'Uzytkownik zostal zaktualizowany');

    }

}