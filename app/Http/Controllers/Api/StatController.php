<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Puzzle;

class StatController extends Controller
{
    /**
     * Retourne les statistiques des puzzles
     */
    public function stats()
    {
        // Nombre total de puzzles
        $totalPuzzles = Puzzle::count(); 
        
        // Quantité totale vendue par puzzle_id
        $ventesParPuzzle = DB::table('orders')
                            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(articles, "$[*].puzzle_id")) as puzzle_id'),
                                     DB::raw('JSON_UNQUOTE(JSON_EXTRACT(articles, "$[*].quantity")) as total_vendu'))
                            ->get();

        // Initialiser un tableau pour stocker les quantités par puzzle_id
        $quantiteParPuzzle = [];

        foreach ($ventesParPuzzle as $vente) {
            // Vérification si 'puzzle_id' et 'total_vendu' sont des données JSON valides
            $puzzleIds = json_decode($vente->puzzle_id, true); // true pour retourner un tableau au lieu d'un objet
            $quantites = json_decode($vente->total_vendu, true);

            // Vérifier que les données décodées sont bien des tableaux
            if (is_array($puzzleIds) && is_array($quantites)) {
                // Ajouter la quantité pour chaque puzzle_id
                foreach ($puzzleIds as $index => $puzzleId) {
                    if (isset($quantiteParPuzzle[$puzzleId])) {
                        $quantiteParPuzzle[$puzzleId]['quantite'] += $quantites[$index];
                    } else {
                        // Récupérer le nom du puzzle
                        $puzzle = Puzzle::find($puzzleId);
                        $quantiteParPuzzle[$puzzleId] = [
                            'nom' => $puzzle ? $puzzle->nom : 'Inconnu',
                            'quantite' => $quantites[$index]
                        ];
                    }
                }
            }
        }

        // Trier par quantité en ordre décroissant
        usort($quantiteParPuzzle, function ($a, $b) {
            return $b['quantite'] <=> $a['quantite'];  // Inverser l'ordre pour décroissant
        });

        // Retourner les statistiques sous forme de JSON
        return response()->json([
            'total_puzzles_différent' => $totalPuzzles,
            'ventes_par_puzzle' => array_map(function ($item) {
                // Enlever l'ID et ne garder que nom et quantité
                return [
                    'nom' => $item['nom'],
                    'quantite' => $item['quantite']
                ];
            }, $quantiteParPuzzle)
        ]);
    }
}
