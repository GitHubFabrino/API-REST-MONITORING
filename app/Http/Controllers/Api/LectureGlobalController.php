<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureGlobal;

use Illuminate\Http\JsonResponse;

class LectureGlobalController extends Controller
{
    public function index(): JsonResponse
    {
        $data = LectureGlobal::with('parc')->get();
        return response()->json($data, 200);
    }

    public function show(int $id): JsonResponse
    {
        $data = LectureGlobal::with('parc')->findOrFail($id);
        return response()->json($data, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tension_total' => 'required|numeric',
            'courant_total' => 'required|numeric',
            'temperature_moyenne' => 'required|numeric',
            'soc_global' => 'required|integer',
            'dod_global' => 'required|integer',
            'horodatage' => 'required|date',
            'parc_id' => 'required|exists:parcs,id',
        ]);

        $lectureGlobal = LectureGlobal::create($validated);
        return response()->json($lectureGlobal, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'tension_total' => 'required|numeric',
            'courant_total' => 'required|numeric',
            'temperature_moyenne' => 'required|numeric',
            'soc_global' => 'required|integer',
            'dod_global' => 'required|integer',
            'horodatage' => 'required|date',
            'parc_id' => 'required|exists:parcs,id',
        ]);

        $lectureGlobal = LectureGlobal::findOrFail($id);
        $lectureGlobal->update($validated);
        return response()->json($lectureGlobal, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $lectureGlobal = LectureGlobal::findOrFail($id);
        $lectureGlobal->delete();
        return response()->json(null, 204);
    }
}
