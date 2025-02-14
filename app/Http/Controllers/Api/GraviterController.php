<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Graviter;


class GraviterController extends Controller
{
    // Récupérer tous les niveaux de gravité
    public function index()
    {
        $graviters = Graviter::all();
        return response()->json($graviters, 200);
    }

    // Créer un nouveau niveau de gravité
    public function store(Request $request)
    {
        $request->validate([
            'niveau' => 'required|string|max:255',
        ]);

        $graviter = Graviter::create($request->all());

        return response()->json($graviter, 201);
    }

    // Afficher un niveau de gravité spécifique
    public function show($id)
    {
        $graviter = Graviter::findOrFail($id);
        return response()->json($graviter, 200);
    }

    // Mettre à jour un niveau de gravité existant
    public function update(Request $request, $id)
    {
        $request->validate([
            'niveau' => 'required|string|max:255',
        ]);

        $graviter = Graviter::findOrFail($id);
        $graviter->update($request->all());

        return response()->json($graviter, 200);
    }

    // Supprimer un niveau de gravité
    public function destroy($id)
    {
        $graviter = Graviter::findOrFail($id);
        $graviter->delete();

        return response()->json(null, 204);
    }
}
