<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HistoriqueMesureSysteme;


class HistoriqueMesureSystemeController extends Controller
{
    public function index()
    {
        return HistoriqueMesureSysteme::all();
    }

    public function show($id)
    {
        return HistoriqueMesureSysteme::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'parc_id' => 'required|exists:parcs,id'
        ]);

        $historique = HistoriqueMesureSysteme::create($validated);
        return response()->json($historique, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
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
            'parc_id' => 'required|exists:parcs,id'
        ]);

        $historique = HistoriqueMesureSysteme::findOrFail($id);
        $historique->update($validated);
        return response()->json($historique, 200);
    }

    public function destroy($id)
    {
        $historique = HistoriqueMesureSysteme::findOrFail($id);
        $historique->delete();
        return response()->json(null, 204);
    }
}
