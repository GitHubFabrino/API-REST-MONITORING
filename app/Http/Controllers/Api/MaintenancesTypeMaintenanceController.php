<?php
// app/Http/Controllers/MaintenancesTypeMaintenanceController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MaintenancesTypeMaintenance;

use Illuminate\Http\JsonResponse;

class MaintenancesTypeMaintenanceController extends Controller
{
    public function index(): JsonResponse
    {
        $data = MaintenancesTypeMaintenance::with(['maintenance', 'typeMaintenance'])->get();
        return response()->json($data, 200);
    }

    public function show(int $id): JsonResponse
    {
        $data = MaintenancesTypeMaintenance::with(['maintenance', 'typeMaintenance'])->findOrFail($id);
        return response()->json($data, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'maintenance_id' => 'required|exists:maintenances,id',
            'type_maintenance_id' => 'required|exists:type_maintenances,id',
        ]);

        $data = MaintenancesTypeMaintenance::create($validated);
        return response()->json($data, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'maintenance_id' => 'required|exists:maintenances,id',
            'type_maintenance_id' => 'required|exists:type_maintenances,id',
        ]);

        $data = MaintenancesTypeMaintenance::findOrFail($id);
        $data->update($validated);
        return response()->json($data, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $data = MaintenancesTypeMaintenance::findOrFail($id);
        $data->delete();
        return response()->json(null, 204);
    }
}
