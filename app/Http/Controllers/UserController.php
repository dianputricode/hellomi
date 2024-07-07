<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.user.login');
    }

    public function showRegistrationForm()
    {
        return view('pages.user.register');
    }

    public function sendEmailVerification(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', 'Email sudah diverifikasi.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Email verifikasi telah dikirim ulang.');
    }
}
