<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Maintenance;

use Illuminate\Http\JsonResponse;

class MaintenanceController extends Controller
{
    /**
     * Affiche une liste de toutes les maintenances.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $maintenances = Maintenance::all();
        return response()->json($maintenances, 200);
    }

    /**
     * Affiche les détails d'une maintenance spécifique.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $maintenance = Maintenance::findOrFail($id);
        return response()->json($maintenance, 200);
    }

    /**
     * Crée une nouvelle maintenance.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'details' => 'required|string',
            'marque' => 'required|string',
            'batterie_id' => 'required|exists:batteries,id',
        ]);

        $maintenance = Maintenance::create($validated);
        return response()->json($maintenance, 201);
    }

    public function getMaintenancesByBatterie(int $batterie_id): JsonResponse
    {
        // Récupérer les maintenances avec les données de la batterie associée
        $maintenances = Maintenance::where('batterie_id', $batterie_id)
            ->with('batterie')
            ->get();
        // Structurer la réponse JSON pour inclure les données de la batterie 
        $data = $maintenances->map(function ($maintenance) {
            return ['maintenance' => $maintenance];
        });
        return response()->json($data, 200);
    }

    /**
     * Met à jour une maintenance existante.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'details' => 'required|string',
            'batterie_id' => 'required|exists:batteries,id',
            'marque'=> 'required|string'
        ]);

        $maintenance = Maintenance::findOrFail($id);

        $maintenance->details = $validated['details'];
        $maintenance->batterie_id = $validated['batterie_id'];
        $maintenance->marque = $validated['marque'];
        $maintenance->save();

        return response()->json($maintenance, 200);
    }

    /**
     * Supprime une maintenance.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();
        return response()->json(null, 204);
    }
}
