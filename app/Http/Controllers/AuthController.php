<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use Illuminate\View\View;

class AuthController
{
    public function index(): View
    {
        return view('auth.sign-in');
    }

    public function login(SignInRequest $request)
    {
        $validated = $request->validated();
    }
}
