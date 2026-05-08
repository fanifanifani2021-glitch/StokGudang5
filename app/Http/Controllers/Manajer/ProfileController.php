<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('manajer.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('manajer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'   => 'required|string|max:150',
            'email'  => 'required|email|max:150|unique:users,email,' . $user->id,
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ];

        if ($request->filled('password')) {
            $rules['password']              = 'min:6|confirmed';
            $rules['password_confirmation'] = 'required_with:password';
        }

        $request->validate($rules, [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan akun lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = $request->only('name', 'email', 'no_hp', 'alamat');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('manajer.profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
