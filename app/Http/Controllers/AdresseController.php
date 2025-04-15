<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adresse;
use App\Models\User;



// importer la façade Auth pour modifier la table user
use Illuminate\Support\Facades\Auth;


class AdresseController extends Controller
{
    public function index()
    {
        // Récupérer les adresses de l'utilisateur connecté uniquement
        $adresse = Adresse::where('user_id', auth()->user()->id)->first();
        // Retourner la vue avec les adresses
        return view('adresse.index', compact('adresse'));
    }


    public function edit()
    {
        // Récupérer les adresses de l'utilisateur connecté uniquement
        $adresse = Adresse::where('user_id', auth()->user()->id)->first();
        // Retourner la vue avec les adresses
        return view('adresse.edit', compact('adresse'));
    }

    public function create()
    {
        return view('adresse.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deliv_adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|numeric|digits_between:4,10',
            'adresse_facturation' => 'required|string|max:255',
        ]);


        //Creation d'une adresse'
        $adresse = new Adresse();
        $adresse -> deliv_adresse = $request-> deliv_adresse;
        $adresse->code_postal = $request->code_postal;
        $adresse->ville = $request->ville;
        $adresse-> adresse_facturation = $request-> adresse_facturation;
        $adresse->user_id = Auth::id();
        $adresse->save();
        return redirect()->route('adresse.index')->with('message', "L'adresse a bien été ajoutée !");
    }


    public function update(Request $request)
    {
        $data = $request->validate([
            'deliv_adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|numeric|regex:/^\d{5}$/',
            'adresse_facturation' => 'required|string|max:255',
        ]);

        // Récupère l'adresse de livraison de l'utilisateur connecté
        $adresse = Adresse::where('user_id', auth()->user()->id)->first();

        // Mettre à jour les informations de l'utilisateur
        $adresse->deliv_adresse = $request->deliv_adresse; // Utilisez $data pour récupérer l'adresse validée
        $adresse->ville = $request->ville; // Utilisez $data pour récupérer la ville
        $adresse->code_postal = $request->code_postal; // Utilisez $data pour récupérer le code postal validé
        $adresse->adresse_facturation = $request->adresse_facturation; // Utilisez $data pour récupérer l'adresse factu
        $adresse->user_id = Auth::id();
        $adresse->save();

        return redirect()->route('adresse.index')->with('message', "L'adresse a bien été mise à jour !");
    }

    public function verifierAdresse()
    {
        // Récupère l'adresse de livraison de l'utilisateur connecté
        $adresse = Adresse::where('user_id', auth()->user()->id)->first();

        if (is_null($adresse)) {
            // Redirige vers la page de création d'adresse si aucune adresse n'est trouvée
            return redirect()->route('adresse.create');
        } else {
            // Redirige vers la page index des adresses si une adresse existe
            return redirect()->route('adresse.index');
        }
    }

}
