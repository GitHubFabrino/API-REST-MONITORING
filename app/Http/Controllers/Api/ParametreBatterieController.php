<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParametreBatterie;
use Illuminate\Http\Request;

class ParametreBatterieController extends Controller
{
    /**
     * Afficher la liste des paramètres des batteries.
     */
    public function index()
    {
        // Retourner tous les paramètres des batteries
        return response()->json(ParametreBatterie::all(), 200);
    }

    /**
     * Créer un nouveau paramètre de batterie.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'plage_temperature_min' => 'required|numeric',
            'plage_temperature_max' => 'required|numeric',
            'plage_tension_min' => 'required|numeric',
            'plage_tension_max' => 'required|numeric',
            'plage_courant_min' => 'required|numeric',
            'plage_courant_max' => 'required|numeric',
            'plage_puissance_min' => 'required|numeric',
            'plage_puissance_max' => 'required|numeric',
            'seuil_alerte_soc' => 'required|numeric',
            'seuil_alerte_dod' => 'required|numeric',
            'profondeur_charge_max' => 'required|numeric',
        ]);

        // Créer un nouveau paramètre de batterie
        $parametre = ParametreBatterie::create($request->all());

        // Retourner une réponse avec le paramètre créé
        return response()->json($parametre, 201);
    }

    /**
     * Afficher un paramètre de batterie spécifique.
     */
    public function show($id)
    {
        $parametre = ParametreBatterie::find($id);

        if ($parametre) {
            return response()->json($parametre, 200);
        } else {
            return response()->json(['message' => 'Paramètre non trouvé'], 404);
        }
    }

    /**
     * Mettre à jour un paramètre de batterie existant.
     */
    public function update(Request $request, $id)
    {
        // Valider les données de la requête
        $request->validate([
            'plage_temperature_min' => 'numeric',
            'plage_temperature_max' => 'numeric',
            'plage_tension_min' => 'numeric',
            'plage_tension_max' => 'numeric',
            'plage_courant_min' => 'numeric',
            'plage_courant_max' => 'numeric',
            'plage_puissance_min' => 'numeric',
            'plage_puissance_max' => 'numeric',
            'seuil_alerte_soc' => 'numeric',
            'seuil_alerte_dod' => 'numeric',
            'profondeur_charge_max' => 'numeric',
        ]);

        $parametre = ParametreBatterie::find($id);

        if ($parametre) {
            $parametre->update($request->all());
            return response()->json($parametre, 200);
        } else {
            return response()->json(['message' => 'Paramètre non trouvé'], 404);
        }
    }

    /**
     * Supprimer un paramètre de batterie.
     */
    public function destroy($id)
    {
        $parametre = ParametreBatterie::find($id);

        if ($parametre) {
            $parametre->delete();
            return response()->json(['message' => 'Paramètre supprimé avec succès'], 200);
        } else {
            return response()->json(['message' => 'Paramètre non trouvé'], 404);
        }
    }
}
