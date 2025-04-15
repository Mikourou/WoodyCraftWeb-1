<?php

namespace App\Http\Controllers;
use App\Models\Category;
//On utilise le modèle puzzle pour recuperer les puzzle et afficher leur spécificités depuis la vue catégories.show
use App\Models\Puzzle;



use Illuminate\Http\Request;

class CategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category::all();
        return view('categories.index', compact('cat'));
    }

            /**
     * Display a category form.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'required|max:500',
            'path_image' => 'required|max:100',
        ]);


        //Creation du puzzle
        $category = new Category();
        $category->libelle = $request->libelle;
        $category->description = $request->description;
        $category->path_image = $request->path_image;
        $category->save();
        return back()->with('message', "La categorie a bien été crée !");
    }

    /**
     * Display the specified resource.
     */
    public function show($idCat)
    {
        // Récupère la catégorie avec ses puzzles
        $categorie = Category::with('puzzles')->find($idCat);
        $puzzles = Puzzle::all();

        // Renvoie les puzzles associés à cette catégorie à la vue
        return view('categories.show', ['puzzles' => $categorie->puzzles, 'categories' => $categorie]);
    }

}
