<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* Pour tester depuis Postman : 
        Méthode POST : http://127.0.0.1:8000/api/authentificate
        Body : 
        {
            "email": "e@e",
            "password": "abcdefgh"
        }
    */ 
    public function authenticate(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cherche l'utilisateur dans la table logins
        $login = Login::where('email', $request->email)->first();

        // Vérifie si l'utilisateur existe
        if (!$login) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Vérifie si le mot de passe est correct
        if (Hash::check($request->password, $login->password)) {
            // Authentification réussie, renvoyer les informations de l'utilisateur
            return response()->json($login);
        } else {
            // Mot de passe incorrect
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
