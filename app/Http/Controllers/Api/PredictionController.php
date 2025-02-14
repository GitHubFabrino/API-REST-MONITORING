<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // public function predict(Request $request)
    // {
    //     // Récupérer les données d'entrée
    //     $input_data = $request->input('data');  // Assurez-vous de valider ces données !

    //     // Convertir les données en une chaîne pour passer au script Python
    //     $data_str = implode(' ', $input_data);

    //     $command = "python3 \"/media/fabrino/7D0510B60DAB790E1/document fianarana/DevellopementWeb/dev_Laravel/APIREST-Monitoring/storage/app/models/predict.py\" $data_str";

    //     // Exécuter la commande et récupérer le résultat
    //     $output = shell_exec($command);

    //     // Retourner la prédiction dans la réponse JSON
    //     // return response()->json(['prediction' => trim($output)]);
    //     return response()->json(['prediction' => trim($output)]);
    // }

    public function predict(Request $request)
    {
        // Validation des données d'entrée sans les unités
        $validated = $request->validate([
            'Cycles' => 'required|numeric',
            'T_charge' => 'required|numeric',
            'T_discharge' => 'required|numeric',
            'V_charge' => 'required|numeric',
            'V_discharge' => 'required|numeric',
            'V_max_dis' => 'required|numeric',
            'V_min_chg' => 'required|numeric',
            'I_charge' => 'required|numeric',
            'I_discharge' => 'required|numeric',
            'T_charge_temp' => 'required|numeric',
            'T_discharge_temp' => 'required|numeric',
        ]);

        // Extraire les données validées
        $input_data = [
            'Cycles' => $validated['Cycles'],
            'T_charge' => $validated['T_charge'],
            'T_discharge' => $validated['T_discharge'],
            'V_charge' => $validated['V_charge'],
            'V_discharge' => $validated['V_discharge'],
            'V_max_dis' => $validated['V_max_dis'],
            'V_min_chg' => $validated['V_min_chg'],
            'I_charge' => $validated['I_charge'],
            'I_discharge' => $validated['I_discharge'],
            'T_charge_temp' => $validated['T_charge_temp'],
            'T_discharge_temp' => $validated['T_discharge_temp'],
        ];

        // Convertir les données en une chaîne pour les passer au script Python
        $data_str = implode(' ', $input_data);

        // Définir les chemins des modèles et du script Python
        $model_rul_path = storage_path('/app/models/Random Forest_rul_model.pkl');
        $model_soh_path = storage_path('/app/models/Random Forest_soh_model.pkl');
        $script_path = storage_path('/app/models/predict.py');

        // Construire la commande pour exécuter le script Python avec les bons arguments
        $command = "python3 \"$script_path\" \"$model_rul_path\" \"$model_soh_path\" $data_str";

        // Exécuter la commande et récupérer le résultat
        $output = shell_exec($command);
        $predictionData = json_decode($output, true);

        // Retourner la prédiction dans la réponse JSON
        if ($output) {
            return response()->json($predictionData);
        } else {
            return response()->json(['error' => 'Erreur lors de l\'exécution du script Python'], 500);
        }
    }
}
