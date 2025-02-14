<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NiveauAnteriorite;


class NiveauAnterioriteController extends Controller
{
    public function index()
    {
        $niveaux = NiveauAnteriorite::all();
        return response()->json($niveaux, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'anterioriter' => 'required|string|max:255',
        ]);

        $niveau = NiveauAnteriorite::create($request->all());
        return response()->json($niveau, 201);
    }

    public function show($id)
    {
        $niveau = NiveauAnteriorite::findOrFail($id);
        return response()->json($niveau, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anterioriter' => 'required|string|max:255',
        ]);

        $niveau = NiveauAnteriorite::findOrFail($id);
        $niveau->update($request->all());
        return response()->json($niveau, 200);
    }

    public function destroy($id)
    {
        NiveauAnteriorite::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
