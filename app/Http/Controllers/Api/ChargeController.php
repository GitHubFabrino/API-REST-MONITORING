<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Charge;

use Illuminate\Http\JsonResponse;

class ChargeController extends Controller
{
    public function index(): JsonResponse
    {
        $charges = Charge::with('parc')->get();
        return response()->json($charges, 200);
    }

    public function show(int $id): JsonResponse
    {
        $charge = Charge::with('parc')->findOrFail($id);
        return response()->json($charge, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom_equipement' => 'required|string|max:255',
            'type_equipement' => 'required|string|max:255',
            'type_source' => 'required|string|max:255',
            'puissance_equipement' => 'required|numeric',
            'tension_equipement' => 'required|numeric',
            'courant_equipement' => 'required|numeric',
            'parc_id' => 'required|exists:parcs,id',
        ]);

        $charge = Charge::create($validated);
        return response()->json($charge, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'nom_equipement' => 'required|string|max:255',
            'type_equipement' => 'required|string|max:255',
            'type_source' => 'required|string|max:255',
            'puissance_equipement' => 'required|numeric',
            'tension_equipement' => 'required|numeric',
            'courant_equipement' => 'required|numeric',
            'parc_id' => 'required|exists:parcs,id',
        ]);

        $charge = Charge::findOrFail($id);
        $charge->update($validated);
        return response()->json($charge, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $charge = Charge::findOrFail($id);
        $charge->delete();
        return response()->json(null, 204);
    }
}
