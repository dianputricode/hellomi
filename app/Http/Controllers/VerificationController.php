<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verify(Request $request, $token)
    {
        // Find the user by verification token
        $user = User::where('verification_token', $token)->firstOrFail();

        // Check if the user's email is already verified
        if (!$user->email_verified_at) {
            // Update user's email verification status and clear verification token
            $user->update([
                'email_verified_at' => now(),
                'verification_token' => null,
            ]);

            // Redirect to login page with success message
            return redirect()->route('login')->with('success', 'Email Anda berhasil diverifikasi.');
        }

        // Redirect to login page with error message if email is already verified
        return redirect()->route('login')->with('error', 'Email sudah terverifikasi atau token tidak valid.');
    }
}
