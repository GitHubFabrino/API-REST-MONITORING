<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AlerteGlobal;


class AlerteGlobalController extends Controller
{
    // Récupérer toutes les alertes globales
    public function index()
    {
        $alertes = AlerteGlobal::with(['typeAlerte', 'graviter', 'contact'])->get();
        return response()->json($alertes, 200);
    }

    // Créer une nouvelle alerte globale
    public function store(Request $request)
    {
        $request->validate([
            'valeur_alerte' => 'required|string|max:255',
            'valeur_seuil' => 'required|string|max:255',
            'horodatage' => 'required|date',
            'type_alerte_id' => 'required|exists:type_alertes,id',
            'graviter_id' => 'required|exists:graviters,id',
            'contact_id' => 'required|exists:contacts,id'
        ]);

        $alerte = AlerteGlobal::create($request->all());

        return response()->json($alerte, 201);
    }

    // Afficher une alerte globale spécifique
    public function show($id)
    {
        $alerte = AlerteGlobal::with(['typeAlerte', 'graviter', 'contact'])->findOrFail($id);
        return response()->json($alerte, 200);
    }

    // Mettre à jour une alerte globale existante
    public function update(Request $request, $id)
    {
        $request->validate([
            'valeur_alerte' => 'required|string|max:255',
            'valeur_seuil' => 'required|string|max:255',
            'horodatage' => 'required|date',
            'type_alerte_id' => 'required|exists:type_alertes,id',
            'graviter_id' => 'required|exists:graviters,id',
            'contact_id' => 'required|exists:contacts,id'
        ]);

        $alerte = AlerteGlobal::findOrFail($id);
        $alerte->update($request->all());

        return response()->json($alerte, 200);
    }

    // Supprimer une alerte globale
    public function destroy($id)
    {
        $alerte = AlerteGlobal::findOrFail($id);
        $alerte->delete();

        return response()->json(null, 204);
    }
}
