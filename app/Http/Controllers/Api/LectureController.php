<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batterie;
use Illuminate\Http\Request;
use App\Models\Lecture;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer toutes les lectures
        return response()->json(Lecture::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données reçues dans la requête
        $request->validate([
            'tension' => 'required|numeric',
            'courant' => 'required|numeric',
            'temperature' => 'required|numeric',
            'soc' => 'required|integer|min:0|max:100',
            'dod' => 'required|integer|min:0|max:100',
            // 'horodatage' => 'required|date',
            'batterie_id' => 'required|exists:batteries,id' // S'assurer que l'ID de la batterie existe
        ]);

        // Créer une nouvelle instance de Lecture avec les données validées
        $lecture = Lecture::create($request->all());

        // Retourner une réponse JSON avec la lecture créée et un code 201 (Created)
        return response()->json($lecture, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Récupérer une lecture par son ID
        $lecture = Lecture::find($id);

        if ($lecture) {
            return response()->json($lecture, 200);
        } else {
            return response()->json(['message' => 'Lecture not found'], 404);
        }
    }

    public function getLectureByParcId($parcId)
    {
        $batteries = Batterie::where('parc_id', $parcId)->get();
        $data = $batteries->map(function ($batterie) {
            $lectures = Lecture::where('batterie_id', $batterie->id)->get();
            return [
                'batterie_id' => $batterie->id,
                'lectures' => $lectures,
            ];
        });

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valider les données
        $request->validate([
            'tension' => 'numeric',
            'courant' => 'numeric',
            'temperature' => 'numeric',
            'soc' => 'integer|min:0|max:100',
            'dod' => 'integer|min:0|max:100',
            // 'horodatage' => 'date',
            'batterie_id' => 'exists:batteries,id' // S'assurer que l'ID de la batterie existe
        ]);

        // Trouver la lecture à mettre à jour
        $lecture = Lecture::find($id);

        if ($lecture) {
            // Mettre à jour la lecture avec les nouvelles données
            $lecture->update($request->all());

            return response()->json($lecture, 200);
        } else {
            return response()->json(['message' => 'Lecture not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Trouver la lecture à supprimer
        $lecture = Lecture::find($id);

        if ($lecture) {
            $lecture->delete();
            return response()->json(['message' => 'Lecture deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Lecture not found'], 404);
        }
    }

    /**
     * Get lectures by batterie_id.
     */
    public function getByBatterieId($batterie_id)
    {
        // Récupérer toutes les lectures associées à un batterie_id donné
        $lectures = Lecture::where('batterie_id', $batterie_id)->get();

        if ($lectures->isEmpty()) {
            return response()->json(['message' => 'No lectures found for this batterie_id'], 404);
        }

        return response()->json($lectures, 200);
    }


    // public function getAllDataPredict($batterieId){
    //     $lectures = Lecture::where('batterie_id', $batterieId)->get();

    //     if ($lectures->isEmpty()) {
    //         return response()->json(['message' => 'No lectures found for this batterie_id'], 404);
    //     }




    //     echo $lectures; 

    //     return response()->json($lectures, 200);
    // }

//     public function getAllDataPredict($batterieId)
// {
//     // Récupérer toutes les lectures pour la batterie donnée
//     $lectures = Lecture::where('batterie_id', $batterieId)
//                         ->orderBy('created_at')
//                         ->get();

//     if ($lectures->isEmpty()) {
//         return response()->json(['message' => 'No lectures found for this batterie_id'], 404);
//     }

//     // Initialiser les variables pour suivre les cycles
//     $currentCycle = 0.0;
//     $isCharging = null;
//     $previousSoc = $lectures[0]->soc;

//     // Parcourir les lectures pour calculer les cycles
//     foreach ($lectures as $lecture) {
//         // Déterminer si la batterie est en charge ou en décharge
//         if ($lecture->soc > $previousSoc) {
//             $isCharging = true;
//         } elseif ($lecture->soc < $previousSoc) {
//             $isCharging = false;
//         }

//         // Calculer le changement de SOC
//         $socChange = abs($lecture->soc - $previousSoc);

//         // Mettre à jour le cycle actuel
//         if ($isCharging !== null) {
//             $currentCycle += $socChange / 100.0;
//         }

//         // Mettre à jour le SOC précédent
//         $previousSoc = $lecture->soc;
//     }

//     return response()->json(['batterie_id' => $batterieId, 'charge_cycles' => $currentCycle], 200);
// }

// public function getAllDataPredict($batterieId)
// {
//     // Récupérer toutes les lectures pour la batterie donnée
//     $lectures = Lecture::where('batterie_id', $batterieId)
//                         ->orderBy('created_at')
//                         ->get();

//     if ($lectures->isEmpty()) {
//         return response()->json(['message' => 'No lectures found for this batterie_id'], 404);
//     }

//     // Initialiser les variables pour suivre les cycles et les temps
//     $currentCycle = 0.0;
//     $totalChargeTime = 0;
//     $totalDischargeTime = 0;
//     $isCharging = null;
//     $previousSoc = $lectures[0]->soc;
//     $previousTime = strtotime($lectures[0]->created_at);

//     // Parcourir les lectures pour calculer les cycles et les temps
//     foreach ($lectures as $lecture) {
//         $currentTime = strtotime($lecture->created_at);
//         $timeDifference = $currentTime - $previousTime; // Différence en secondes

//         // Déterminer si la batterie est en charge ou en décharge
//         if ($lecture->soc > $previousSoc) {
//             $isCharging = true;
//             $totalChargeTime += $timeDifference;
//         } elseif ($lecture->soc < $previousSoc) {
//             $isCharging = false;
//             $totalDischargeTime += $timeDifference;
//         }

//         // Calculer le changement de SOC
//         $socChange = abs($lecture->soc - $previousSoc);

//         // Mettre à jour le cycle actuel
//         if ($isCharging !== null) {
//             $currentCycle += $socChange / 100.0;
//         }

//         // Mettre à jour le SOC précédent et le temps précédent
//         $previousSoc = $lecture->soc;
//         $previousTime = $currentTime;
//     }

//     // Convertir les temps en heures pour une meilleure lisibilité
//     $totalChargeTimeHours = $totalChargeTime / 3600;
//     $totalDischargeTimeHours = $totalDischargeTime / 3600;

//     return response()->json([
//         'batterie_id' => $batterieId,
//         'charge_cycles' => $currentCycle,
//         'total_charge_time_hours' => $totalChargeTimeHours,
//         'total_discharge_time_hours' => $totalDischargeTimeHours
//     ], 200);
// }

public function getAllDataPredict($batterieId)
{
    // Récupérer toutes les lectures pour la batterie donnée
    $lectures = Lecture::where('batterie_id', $batterieId)
                        ->orderBy('created_at')
                        ->get();

    if ($lectures->isEmpty()) {
        return response()->json(['message' => 'No lectures found for this batterie_id'], 404);
    }

    // Initialiser les variables pour suivre les cycles et les moyennes
    $totalDischarge = 0;
    $totalChargeTime = 0;
    $totalDischargeTime = 0;
    $chargeTensions = [];
    $dischargeTensions = [];
    $chargeCurrents = [];
    $dischargeCurrents = [];
    $chargeTemperatures = [];
    $dischargeTemperatures = [];
    $previousSoc = $lectures[0]->soc;
    $previousTime = strtotime($lectures[0]->created_at);

    // Parcourir les lectures pour calculer les cycles et les moyennes
    foreach ($lectures as $lecture) {
        $currentTime = strtotime($lecture->created_at);
        $timeDifference = $currentTime - $previousTime; // Différence en secondes

        // Déterminer si la batterie est en charge ou en décharge
        if ($lecture->soc > $previousSoc) {
            // Charge détectée
            $totalChargeTime += $timeDifference;
            $chargeTensions[] = $lecture->tension;
            $chargeCurrents[] = $lecture->courant;
            $chargeTemperatures[] = $lecture->temperature;
        } elseif ($lecture->soc < $previousSoc) {
            // Décharge détectée
            $totalDischargeTime += $timeDifference;
            $totalDischarge += abs($lecture->soc - $previousSoc);
            $dischargeTensions[] = $lecture->tension;
            $dischargeCurrents[] = $lecture->courant;
            $dischargeTemperatures[] = $lecture->temperature;
        }

        // Mettre à jour le SOC précédent et le temps précédent
        $previousSoc = $lecture->soc;
        $previousTime = $currentTime;
    }

    // Calculer le nombre total de cycles
    $totalCycles = $totalDischarge / 100;

    // Calculer les moyennes
    $avgChargeVoltage = count($chargeTensions) ? array_sum($chargeTensions) / count($chargeTensions) : 0;
    $avgDischargeVoltage = count($dischargeTensions) ? array_sum($dischargeTensions) / count($dischargeTensions) : 0;
    $avgChargeCurrent = count($chargeCurrents) ? array_sum($chargeCurrents) / count($chargeCurrents) : 0;
    $avgDischargeCurrent = count($dischargeCurrents) ? array_sum($dischargeCurrents) / count($dischargeCurrents) : 0;
    $avgChargeTemperature = count($chargeTemperatures) ? array_sum($chargeTemperatures) / count($chargeTemperatures) : 0;
    $avgDischargeTemperature = count($dischargeTemperatures) ? array_sum($dischargeTemperatures) / count($dischargeTemperatures) : 0;

    // Retourner les résultats sous forme de réponse JSON
    return response()->json([
        'batterie_id' => $batterieId,
        'total_cycles' => $totalCycles,
        'total_charge_time_seconds' => $totalChargeTime,
        'total_discharge_time_seconds' => $totalDischargeTime,
        'avg_charge_voltage' => $avgChargeVoltage,
        'avg_discharge_voltage' => $avgDischargeVoltage,
        'avg_charge_current' => $avgChargeCurrent,
        'avg_discharge_current' => $avgDischargeCurrent,
        'avg_charge_temperature' => $avgChargeTemperature,
        'avg_discharge_temperature' => $avgDischargeTemperature
    ], 200);
}


public function getAllDataPredictByParc($parcId)
{
    // Récupérer toutes les batteries associées à un parc donné avec les relations nécessaires
    $batteries = Batterie::with(['parc.contacts', 'parametreBatteries', 'file'])
                        ->where('parc_id', $parcId)
                        ->get();

    // Transformer les données pour inclure les informations nécessaires
    $data = $batteries->map(function ($batterie) {
        // Appeler la fonction calculateCycleSummary pour chaque batterie
        $cycleSummary = $this->getAllDataPredict($batterie->id);

        // Convertir la réponse JSON en tableau associatif
        $cycleSummaryData = json_decode($cycleSummary->getContent(), true);

        // Construire l'URL complète du fichier si un fichier est associé
        $fileUrl = $batterie->file ? asset('storage/uploads/' . $batterie->file->file_name) : null;

        // Mettre à jour l'information du fichier dans la batterie
        if ($batterie->file) {
            $batterie->file->file_name = $fileUrl;
        }

        // Retourner les données de la batterie avec le résumé des cycles
        return [
            'batterie_id' => $batterie->id,
            'batterie_Info' => $batterie,
            'cycle_summary' => $cycleSummaryData,
        ];
    });

    // Retourner les résultats sous forme de réponse JSON
    return response()->json($data, 200);
}


}
