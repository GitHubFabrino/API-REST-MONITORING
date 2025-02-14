<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SystemeParametre;


class SystemeParametreController extends Controller
{
    public function index()
    {
        $systemeParametres = SystemeParametre::with('typeMontage')->get();
        return response()->json($systemeParametres, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_batterie_serie' => 'required',
            'nombre_batterie_parallele' => 'required',
            'type_montage_id' => 'required|exists:type_montages,id',
        ]);

        $systemeParametre = SystemeParametre::create($request->all());
        return response()->json($systemeParametre->load('typeMontage'), 201);
    }

    public function show($id)
    {
        $systemeParametre = SystemeParametre::with('typeMontage')->findOrFail($id);
        return response()->json($systemeParametre, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_batterie_serie' => 'required|string|max:255',
            'nombre_batterie_parallele' => 'required|string|max:255',
            'type_montage_id' => 'required|exists:type_montages,id',
        ]);

        $systemeParametre = SystemeParametre::findOrFail($id);
        $systemeParametre->update($request->all());
        return response()->json($systemeParametre->load('typeMontage'), 200);
    }

    public function destroy($id)
    {
        SystemeParametre::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
