<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HistoriqueMesure;


class HistoriqueMesureController extends Controller
{
    public function index()
    {
        $historiqueMesures = HistoriqueMesure::with('niveauAnteriorite', 'batterie')->get();
        return response()->json($historiqueMesures, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'avg_tension' => 'required|numeric',
            'avg_courant' => 'required|numeric',
            'avg_temperature' => 'required|numeric',
            'avg_soc' => 'required|numeric',
            'avg_dod' => 'required|numeric',
            'avg_soh' => 'required|numeric',
            'min_tension' => 'required|numeric',
            'max_tension' => 'required|numeric',
            'min_courant' => 'required|numeric',
            'max_courant' => 'required|numeric',
            'min_temperature' => 'required|numeric',
            'max_temperature' => 'required|numeric',
            'total_consommation' => 'required|numeric',
            'niveau_anteriorite_id' => 'required|exists:niveau_anteriorites,id',
            'batterie_id' => 'required|exists:batteries,id',
        ]);

        $historiqueMesure = HistoriqueMesure::create($request->all());
        return response()->json($historiqueMesure, 201);
    }

    public function show($id)
    {
        $historiqueMesure = HistoriqueMesure::with('niveauAnteriorite', 'batterie')->findOrFail($id);
        return response()->json($historiqueMesure, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'avg_tension' => 'required|numeric',
            'avg_courant' => 'required|numeric',
            'avg_temperature' => 'required|numeric',
            'avg_soc' => 'required|numeric',
            'avg_dod' => 'required|numeric',
            'avg_soh' => 'required|numeric',
            'min_tension' => 'required|numeric',
            'max_tension' => 'required|numeric',
            'min_courant' => 'required|numeric',
            'max_courant' => 'required|numeric',
            'min_temperature' => 'required|numeric',
            'max_temperature' => 'required|numeric',
            'total_consommation' => 'required|numeric',
            'niveau_anteriorite_id' => 'required|exists:niveau_anteriorites,id',
            'batterie_id' => 'required|exists:batteries,id',
        ]);

        $historiqueMesure = HistoriqueMesure::findOrFail($id);
        $historiqueMesure->update($request->all());
        return response()->json($historiqueMesure, 200);
    }

    public function destroy($id)
    {
        HistoriqueMesure::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
