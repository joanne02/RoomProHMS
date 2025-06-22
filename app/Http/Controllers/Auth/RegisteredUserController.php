<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(siswa\.)?unimas\.my$/',
            ],

            'user_id' => ['required', 'string', 'max:20', 'unique:users,user_id'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                        ->mixedCase()     // requires at least one uppercase and one lowercase letter
                        ->letters()       // requires at least one letter
                        ->numbers()       // requires at least one number
                        ->symbols()       // requires at least one symbol
                ],
            ]);


        $user = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'user_id' => $request->user_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        $notification = [
            'type' => 'success',
            'message' => 'Registration successful! Welcome, ' . $user->username . '!',
        ];

        return redirect()->route('login')->with($notification);

        // return redirect(RouteServiceProvider::HOME)->with($notification);
    }
}
