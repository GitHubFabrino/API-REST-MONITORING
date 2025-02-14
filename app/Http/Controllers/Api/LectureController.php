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
}
