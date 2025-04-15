<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Login;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer'],
            'tel' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:logins'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crée un enregistrement dans la table users
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'tel' => $request->tel
        ]);

        // Crée un enregistrement dans la table logins lié à l'utilisateur
        $login = Login::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // ou un autre rôle par défaut
            'user_id' => $user->id, // Associe le login à l'utilisateur créé
        ]);

        // Déclenche l'événement Registered
        event(new Registered($login));

        // Connecte l'utilisateur via le modèle Logins
        Auth::login($login);

        return redirect()->route('dashboard');
    }
};
