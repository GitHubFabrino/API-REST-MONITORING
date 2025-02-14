<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TypeAlerte;


class TypeAlerteController extends Controller
{
    // Récupérer tous les types d'alertes
    public function index()
    {
        $typeAlertes = TypeAlerte::all();
        return response()->json($typeAlertes, 200);
    }

    // Créer un nouveau type d'alerte
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $typeAlerte = TypeAlerte::create($request->all());

        return response()->json($typeAlerte, 201);
    }

    // Afficher un type d'alerte spécifique
    public function show($id)
    {
        $typeAlerte = TypeAlerte::findOrFail($id);
        return response()->json($typeAlerte, 200);
    }

    // Mettre à jour un type d'alerte existant
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $typeAlerte = TypeAlerte::findOrFail($id);
        $typeAlerte->update($request->all());

        return response()->json($typeAlerte, 200);
    }

    // Supprimer un type d'alerte
    public function destroy($id)
    {
        $typeAlerte = TypeAlerte::findOrFail($id);
        $typeAlerte->delete();

        return response()->json(null, 204);
    }
}
