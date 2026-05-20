<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form (standalone page - fallback).
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the forgot password form submission.
     * Sends a password reset link to the user's email.
     * Returns JSON for AJAX requests, redirects for normal form posts.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // AJAX request — return JSON
        if ($request->expectsJson()) {
            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => __($status),
                ]);
            }

            return response()->json([
                'message' => __($status),
                'errors' => ['email' => [__($status)]],
            ], 422);
        }

        // Normal form submission — redirect back
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)])->withInput();
    }

    /**
     * Show the password reset form (user arrives from email link).
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle the password reset form submission.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(6)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]])->withInput();
    }
}
