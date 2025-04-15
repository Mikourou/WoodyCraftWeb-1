<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_products;
use App\Models\Puzzle;
use App\Models\Basket;

// importer la façade Auth pour modifier la table user
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
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
        return view('paiement.index', compact('basket'));
    }



    public function transaction()
    {
        return redirect()->route('paiement.transaction');
    }

    public function methode()
    {
        return view('paiement.methode');
    }

    public function store(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return back()->withErrors('Vous devez être connecté pour passer une commande.');
        }

        // Récupérer les articles dans le panier pour cet utilisateur
        $basketItems = Basket::with('puzzle')->where('user_id', Auth::id())->get();

        // Vérifier si le panier est vide
        if ($basketItems->isEmpty()) {
            return back()->withErrors('Votre panier est vide.');
        }

        // Calculer le total et préparer les articles
        $total = 0;
        $articles = [];

        foreach ($basketItems as $item) {
            $total += $item->puzzle->prix * $item->quantity; // Calcul du prix total
            $articles[] = [
                'puzzle_id' => $item->puzzle->id,
                'nom' => $item->puzzle->nom,
                'prix' => $item->puzzle->prix,
                'quantity' => $item->quantity,
            ];
        }

        // Valider les données de la commande
        $data = $request->validate([
            'type_paiement' => 'required|string|max:255',
            'methode_paiement' => 'required|string|max:255',
        ]);

        try {
            // Créer une nouvelle commande
            $order = new Order();
            $order->type_paiement = $data['type_paiement'];
            $order->date_commande = now(); // Date de la commande
            $order->articles = json_encode($articles); // Encodage JSON des articles
            $order->total_prix = $total;
            $order->methode_paiement = $data['methode_paiement'];
            $order->statut_commande = 0; // Statut par défaut : en attente
            $order->user_id = Auth::id(); // ID de l'utilisateur connecté

            // Sauvegarder la commande dans la base de données
            $order->save();

            // Supprimer les articles du panier après la création de la commande
            Basket::where('user_id', Auth::id())->delete();

            // Rediriger vers une page de confirmation ou de paiement
            return redirect()->route('pdf')->with('message', 'La commande a été enregistrée avec succès !');
        } catch (\Exception $e) {
            return back()->withErrors('Erreur lors de la sauvegarde de la commande : ' . $e->getMessage());
        }
    }




}
