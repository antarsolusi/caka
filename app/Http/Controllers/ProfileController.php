<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile berhasil diperbarui.');
    }
}
