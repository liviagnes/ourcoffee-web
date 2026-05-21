<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function resetInstant(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|min:6|same:confirm_new_password',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem.',
            'new_password.same' => 'Konfirmasi password tidak cocok.'
        ]);

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect('/login')->with('success', 'Password berhasil diperbarui, silakan login kembali.');
    }
}
