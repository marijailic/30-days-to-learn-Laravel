<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisteredUserStoreRequest;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisteredUserStoreRequest $request)
    {
        $attributes = [
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
            'name' => $request->validated('name'),
        ];

        $user = User::create(Arr::except($attributes, 'name'));

        Employer::create(
            [
                'user_id' => $user->id,
                'name' => $attributes['name'],
            ]
        );

        Auth::login($user);

        return redirect('/jobs');
    }
}
