<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batterie;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return response()->json($files, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'titre' => 'required|string',
            'file' => 'required|file|mimes:jpg,png,pdf,docx'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('public/uploads', $fileName);

        $fileRecord = File::create([
            'titre' =>$fileName,
            'file_name' => $fileName
        ]);

        return response()->json($fileRecord, 201);
    }

    public function show(string $id)
    {
        $file = File::find($id);

        if ($file) {
            $fileUrl = asset('storage/uploads/' . $file->file_name);
            return response()->json(['url' => $fileUrl], 200);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx'
        ]);

        $fileRecord = File::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($fileRecord->file_name) {
                Storage::delete('public/uploads/' . $fileRecord->file_name);
            }

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('public/uploads', $fileName);

            $validatedData['file_name'] = $fileName;
        }

        $fileRecord->update($validatedData);

        return response()->json($fileRecord, 200);
    }

    public function destroy(string $id)
    {
        $fileRecord = File::find($id);

        if ($fileRecord) {
            if ($fileRecord->file_name) {
                Storage::disk('public')->delete('uploads/' . $fileRecord->file_name);
            }

            $fileRecord->delete();
            return response()->json(['message' => 'File deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }


    public function uploadFileBatterie(Request $request, $batId)
    {
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('public/uploads', $fileName);

        $fileRecord = File::create([
            'titre' => $fileName, // Vous pouvez ajuster ceci si nécessaire
            'file_name' => $fileName
        ]);

        $bat = Batterie::findOrFail($batId);
        $bat->file_id = $fileRecord->id;
        $bat->save();

        $fileUrl = asset('storage/uploads/' . $fileRecord->file_name);

        return response()->json(['url' => $fileUrl , 'id' => $fileRecord->id], 200);
    }


    public function uploadFileUser(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx'
        ]);
    
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('public/uploads', $fileName);
    
        // Trouver l'utilisateur
        $user = User::findOrFail($userId);
    
        // Vérifier si l'utilisateur a déjà un fichier associé
        if ($user->file_id) {
            // Mettre à jour le fichier existant
            $fileRecord = File::findOrFail($user->file_id);
            $fileRecord->update([
                'titre' => $fileName,
                'file_name' => $fileName
            ]);
        } else {
            // Créer un nouveau fichier
            $fileRecord = File::create([
                'titre' => $fileName,
                'file_name' => $fileName
            ]);
            $user->file_id = $fileRecord->id;
            $user->save();
        }
    
        $fileUrl = asset('storage/uploads/' . $fileRecord->file_name);
    
        return response()->json(['url' => $fileUrl, 'id' => $fileRecord->id], 200);
    }
    
}
