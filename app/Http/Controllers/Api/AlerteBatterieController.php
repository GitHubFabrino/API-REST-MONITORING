<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batterie;
use Illuminate\Http\Request;
use App\Models\AlerteBatterie;

use Illuminate\Http\JsonResponse;

class AlerteBatterieController extends Controller
{
    public function index(): JsonResponse
    {
        $data = AlerteBatterie::with(['contact', 'batterie'])->get();
        return response()->json($data, 200);
    }

    public function show(int $id): JsonResponse
    {
        $data = AlerteBatterie::with(['contact', 'batterie'])->findOrFail($id);
        return response()->json($data, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'valeur_alerte' => 'required|numeric',
            'valeur_seuil' => 'required|numeric',
            'message' => 'required|string',
            'read' => 'required|boolean',
            'type' => 'required|string',
            'graviter' => 'required|string',
            'contact_id' => 'required|exists:contacts,id',
            'batterie_id' => 'required|exists:batteries,id'
        ]);

        $alerteBatterie = AlerteBatterie::create($validated);
        return response()->json($alerteBatterie, 201);
    }


    // $batteries = Batterie::where('parc_id', $parcId)->get();

    public function getAlerteByBatterieId(int $batterie_id): JsonResponse
    {
        $data = AlerteBatterie::where('batterie_id', $batterie_id)->with(['contact', 'batterie'])->get();
        return response()->json($data, 200);
    }

    public function getAlerteByParcId(int $parcId): JsonResponse
    {
        // Récupérer toutes les batteries associées au parc ID
        $batteries = Batterie::where('parc_id', $parcId)->get();

        // Initialiser un tableau pour stocker les alertes
        $alertes = [];

        // Parcourir chaque batterie et récupérer les alertes associées
        foreach ($batteries as $batterie) {
            $batterieAlertes = AlerteBatterie::where('batterie_id', $batterie->id)
                ->with(['contact', 'batterie'])
                ->get();

            $alertes = array_merge($alertes, $batterieAlertes->toArray());
        }

        return response()->json($alertes, 200);
    }


    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'valeur_alerte' => 'required|numeric',
            'valeur_seuil' => 'required|numeric',
            'message' => 'required|string',
            'read' => 'required|boolean',
            'type' => 'required|string',
            'graviter' => 'required|string',
            'contact_id' => 'nullable|exists:contacts,id',
            'batterie_id' => 'required|exists:batteries,id'
        ]);

        

        $alerteBatterie = AlerteBatterie::findOrFail($id);
        $alerteBatterie->update($validated);
        return response()->json($alerteBatterie, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $alerteBatterie = AlerteBatterie::findOrFail($id);
        $alerteBatterie->delete();
        return response()->json(null, 204);
    }
}
