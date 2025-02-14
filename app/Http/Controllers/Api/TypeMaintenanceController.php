<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeMaintenance;


class TypeMaintenanceController extends Controller
{
   
    public function index()
    {
        $types = TypeMaintenance::all();
        return response()->json($types, 200);
    }

   
    public function show(Request $id)
    {
        $type = TypeMaintenance::findOrFail($id);
        return response()->json($type, 200);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $type = TypeMaintenance::create($validated);
        return response()->json($type, 201);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $type = TypeMaintenance::findOrFail($id);
        $type->update($validated);
        return response()->json($type, 200);
    }


    public function destroy( $id)
    {
        $type = TypeMaintenance::findOrFail($id);
        $type->delete();
        return response()->json(null, 204);
    }
}
