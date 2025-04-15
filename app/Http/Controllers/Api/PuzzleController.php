<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;
use Illuminate\Support\Facades\Validator;

class PuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $puzzles = Puzzle::all();
        // On filtre les champs qui nous intéressent
        $puzzles = $puzzles->map(function ($puzzle) {
            return [
                'id' => $puzzle->id,
                'nom' => $puzzle->nom,
                'description' => $puzzle->description,
                'prix' => $puzzle->prix,
            ];
        });

        return response()->json($puzzles);  // Retourner les données filtrées en JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'path_image' => 'required|string|max:255',
            'prix' => 'required|numeric|between:0,99.99',
            'categorie_id' => 'required|exists:categories,id', // Verifier que la catégorie existe
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'erreur' => $validator->errors()
            ], 422); // Code de statut 422 pour une validation échouée
        }

        // Créer un nouveau puzzle avec les données validées
        $puzzle = Puzzle::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'path_image' => $request->path_image,
            'prix' => $request->prix,
            'categorie_id' => $request->categorie_id,
            // Ajoute d'autres attributs ici si nécessaire
        ]);


        // Retourner la ressource nouvellement créée
        return response()->json([
            'success' => true,
            'message' => 'Puzzle crée avec succès',
            'données' => $puzzle
        ], 201); // Code de statut 201 pour indiquer la création
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $puzzle = Puzzle::findOrFail($id);
        return response()->json($puzzle); // Renvoie l'objet complet
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valider les données envoyées
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'path_image' => 'nullable|string',
            'prix' => 'nullable|numeric',
            'categorie_id' => 'nullable|exists:categories,id', // S'assurer que la catégorie existe
            // Ajoute d'autres règles de validation selon les attributs de ton modèle
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // Code de statut 422 pour une validation échouée
        }

        // Récupérer le puzzle à mettre à jour
        $puzzle = Puzzle::findOrFail($id);

        // Mettre à jour les attributs du puzzle
        $puzzle->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'path_image' => $request->path_image,
            'prix' => $request->prix,
            'categorie_id' => $request->categorie_id,
            // Ajoute d'autres attributs ici si nécessaire
        ]);

        // Retourner une réponse JSON confirmant la mise à jour
        return response()->json([
            'success' => true,
            'message' => 'Puzzle updated successfully',
            'data' => $puzzle
        ], 200); // Code de statut 200 pour indiquer le succès
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $puzzles = Puzzle::findOrFail($id);
        $puzzles->delete();
        return response()->json([
            'success' => true,
            'message' => 'Le Puzzle a été supprimé'
        ], 200); //code statut 200 pour indiquer le succès
    }
}
