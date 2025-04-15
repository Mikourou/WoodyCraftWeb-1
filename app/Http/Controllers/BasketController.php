<?php


namespace App\Http\Controllers;

use App\Models\Puzzle; // Assure-toi que Puzzle est aussi importé
use App\Models\Basket; // Importation du modèle Basket
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class BasketController extends Controller
{
    // Afficher le panier
    public function index()
    {
        if (auth()->check()) {
            // Utilisateur connecté
            $basket = Basket::with('puzzle')->where('user_id', auth()->id())->get();
            // Récupérer les puzzles manuellement pour chaque panier
            foreach ($basket as $item) {
                $item->puzzle = $item->puzzle;  // Charger la relation "puzzle" pour chaque panier
            }
        } else {
            // Utilisateur non connecté
            $basket = session()->get('basket', []);
        }

        return view('basket.index', compact('basket'));
    }

    // Ajouter/Mettre à jour un produit dans le panier
    public function store(Request $request, Puzzle $puzzle)
    {
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            // Utilisateur connecté : Enregistrer dans la base de données
            $basketItem = Basket::updateOrCreate(
                ['user_id' => Auth::id(), 'puzzle_id' => $puzzle->id],
                ['quantity' => $quantity]
            );
        } else {
            // Utilisateur non connecté : Enregistrer dans la session
            $basket = session()->get('basket', []);
            $basket[$puzzle->id] = [
                'nom' => $puzzle->nom,
                'prix' => $puzzle->prix,
                'quantity' => $quantity,
                'path_image' => $puzzle->path_image
            ];
            session()->put('basket', $basket);
        }

        return back()->with('message', 'Produit ajouté au panier !');
    }

    // Retirer un produit du panier
    public function destroy(Puzzle $puzzle)
    {
        if (auth()->check()) {
            // Utilisateur connecté : Supprimer de la base de données
            Basket::where('user_id', auth()->id())->where('puzzle_id', $puzzle->id)->delete();
        } else {
            // Utilisateur non connecté : Supprimer de la session
            $basket = session()->get('basket', []);
            unset($basket[$puzzle->id]);
            session()->put('basket', $basket);
        }

        return redirect()->route('basket.index');
    }

    // Vider le panier
    public function clear()
    {
        if (auth()->check()) {
            // Utilisateur connecté : Vider la base de données
            Basket::where('user_id', auth()->id())->delete();
        } else {
            // Utilisateur non connecté : Vider la session
            session()->forget('basket');
        }

        return redirect()->route('basket.index');
    }
}



