<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParametreBatterie;
use Illuminate\Http\Request;
use App\Models\Batterie;

class BatterieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Batterie::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required',
            'capacite_nominal' => 'required',
            'date_installation' => 'required',
            'technologie' => 'required',
            'marque' => 'required',
            'parc_id' => 'required|exists:parcs,id',
            'description' => 'nullable',
            'tension_nominale' => 'nullable',
            'capacite' => 'nullable',
            'utilisation_veille' => 'nullable',
            'utilisation_cyclique' => 'nullable',
            'courant' => 'nullable',
            'temperature' => 'nullable',
            'dod_max' => 'nullable',
        ]);

        // Créer un paramètre batterie avec des valeurs par défaut
        $defaultParams = [
            'plage_temperature_min' => 0.0,
            'plage_temperature_max' => 0.0,
            'plage_tension_min' => 0.0,
            'plage_tension_max' => 0.0,
            'plage_courant_min' => 0.0,
            'plage_courant_max' => 0.0,
            'plage_puissance_min' => 0.0,
            'plage_puissance_max' => 0.0,
            'seuil_alerte_soc' => 0.0,
            'seuil_alerte_dod' => 0.0,
            'profondeur_charge_max' => 0.0
        ];
        $parametreBatterie = ParametreBatterie::create($defaultParams);

        $batterie = Batterie::create([
            'nom' => $validatedData['nom'],
            'capacite_nominal' => $validatedData['capacite_nominal'],
            'date_installation' => $validatedData['date_installation'],
            'technologie' => $validatedData['technologie'],
            'marque' => $validatedData['marque'],
            'parc_id' => $validatedData['parc_id'],
            'parametre_batterie_id' => $parametreBatterie->id,
            'description' => $validatedData['description'], // Fixed key from 'name' to 'description'
            'tension_nominale' => $validatedData['tension_nominale'],
            'capacite' => $validatedData['capacite'],
            'utilisation_veille' => $validatedData['utilisation_veille'],
            'utilisation_cyclique' => $validatedData['utilisation_cyclique'],
            'courant' => $validatedData['courant'],
            'temperature' => $validatedData['temperature'],
            'dod_max' => $validatedData['dod_max'],
        ]);

        // Retourner une réponse JSON avec la batterie créée et un code 201
        return response()->json($batterie, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $batterie = Batterie::findOrFail($id);
        return response()->json($batterie->load('parc', 'parametreBatteries'), 200);
    }


    // public function getBatteriesByParcId($parcId)
    // {
    //     $batteries = Batterie::where('parc_id', $parcId)->get();
    //     return response()->json($batteries);
    // }

    public function getBatteriesByParcId($parcId)
    {
        $batteries = Batterie::where('parc_id', $parcId)
                    ->with(['parc.contacts', 'parametreBatteries'])
                    ->get();
        return response()->json($batteries);
    }
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required',
            'capacite_nominal' => 'required',
            'date_installation' => 'required',
            'technologie' => 'required',
            'marque' => 'required',
            'parc_id' => 'required|exists:parcs,id',
            'parametre_batterie_id' => 'required|exists:parametre_batteries,id',
            'description' => 'nullable',
            'tension_nominale' => 'nullable',
            'capacite' => 'nullable',
            'utilisation_veille' => 'nullable',
            'utilisation_cyclique' => 'nullable',
            'courant' => 'nullable',
            'temperature' => 'nullable',
            'dod_max' => 'nullable',
        ]);

        $batterie = Batterie::findOrFail($id);
        $batterie->update($request->all());

        return response()->json($batterie, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $batterie = Batterie::findOrFail($id);
        $batterie->delete();

        return response()->json(null, 204);
    }
}
