<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class LoginController extends Controller
{
    // Méthode pour créer un login (POST)
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:logins,email',
            'password' => 'required|min:8',
            'role' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Créer le login
        $login = Login::create([
            'email' => $request->email,
            'password' => bcrypt($request->password), // Assurez-vous de hasher le mot de passe
            'role' => $request->role,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Login créé avec succès', 'data' => $login], 201);
    }

    // Méthode pour récupérer tous les logins (GET)
    public function index()
    {
        $logins = Login::all();
        return response()->json(['data' => $logins], 200);
    }

    // Méthode pour récupérer un login spécifique (GET)
    public function show($id)
    {
        $login = Login::find($id);

        if (!$login) {
            return response()->json(['message' => 'Login non trouvé'], 404);
        }

        return response()->json(['data' => $login], 200);
    }

    // Méthode pour mettre à jour un login (PUT/PATCH)
    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:logins,email,' . $id,
            'password' => 'nullable|min:8',
            'role' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $login = Login::find($id);

        if (!$login) {
            return response()->json(['message' => 'Login non trouvé'], 404);
        }

        // Mettre à jour les informations
        $login->email = $request->email;
        $login->password = $request->has('password') ? bcrypt($request->password) : $login->password;
        $login->role = $request->role;
        $login->user_id = $request->user_id;
        $login->save();

        return response()->json(['message' => 'Login mis à jour avec succès', 'data' => $login], 200);
    }

    // Méthode pour supprimer un login (DELETE)
    public function destroy($id)
    {
        $login = Login::find($id);

        if (!$login) {
            return response()->json(['message' => 'Login non trouvé'], 404);
        }

        $login->delete();

        return response()->json(['message' => 'Login supprimé avec succès'], 200);
    }

    //
    public function authenticate(Request $request)
    {
        // Récupère l'email+password 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Cherche dans la table logins
        $login = Login::where('email', $request->email)->first();

        // Réponse
        return response()->json($login);
    }


}