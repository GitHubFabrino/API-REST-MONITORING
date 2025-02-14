<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeMontage;

class TypeMontageController extends Controller
{
    public function index()
    {
        return response()->json(TypeMontage::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_type' => 'required|string|max:255',
        ]);

        $typeMontage = TypeMontage::create($request->all());
        return response()->json($typeMontage, 201);
    }

    public function show($id)
    {
        $typeMontage = TypeMontage::findOrFail($id);
        return response()->json($typeMontage, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_type' => 'required|string|max:255',
        ]);

        $typeMontage = TypeMontage::findOrFail($id);
        $typeMontage->update($request->all());
        return response()->json($typeMontage, 200);
    }

    public function destroy($id)
    {
        TypeMontage::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
