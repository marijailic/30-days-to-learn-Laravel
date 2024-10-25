<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(SessionStoreRequest $request)
    {
        $attributes = [
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ];

        if(!Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
            ]);
        }

        request()->session()->regenerate();

        return redirect('/jobs');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
