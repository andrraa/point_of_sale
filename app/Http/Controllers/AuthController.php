<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Models\User;
use App\Services\ValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    // LOGIN PAGE
    public function index(): View
    {
        $validator = $this->validationService->generateValidation(SignInRequest::class, '#form-sign-in');

        return view('auth.sign-in', compact(['validator']));
    }

    // LOGIN
    public function login(SignInRequest $request): RedirectResponse
    {
        Session::remove('user');

        $validated = $request->validated();

        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            flash()->preset('auth_failed');

            return redirect()->back();
        }

        Auth::login($user);

        session(['user' => $user->load('role')]);

        flash()->preset('auth_success', ['username' => $user->username]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    // LOGOUT
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Session::remove('user');

        Auth::logout();

        return redirect()->route('dashboard');
    }
}
