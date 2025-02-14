<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\File;
use Illuminate\Http\Request;

use App\Models\Parc;


class ParcController extends Controller
{
    public function index()
    {
        $parcs = Parc::with('user', 'systemeParametre')->get();
        return response()->json($parcs, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_parc' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'phone' => 'required|string|max:255',
            'nombre_batteries' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
            // 'systeme_parametre_id' => 'required|exists:systeme_parametres,id',
        ]);

        $parc = Parc::create([
            'nom_parc' => $validatedData['nom_parc'],
            'email' => $validatedData['email'],
            'description' => $validatedData['description'],
            'nombre_batteries' => $validatedData['nombre_batteries'],
            'adresse' => $validatedData['adresse'],
            'user_id' => $validatedData['user_id'],
        ]);

        $contactEmail = Contact::create([
            'type' => "email",
            'choix' => "oui",
            'valeur' => $validatedData['email'],
            'parc_id' => $parc->id,
        ]);

        $contactPhone = Contact::create([
            'type' => "phone",
            'choix' => "oui",
            'valeur' => $validatedData['phone'],
            'parc_id' => $parc->id,
        ]);

        return response()->json(['parc' => $parc, 'contactEmail' => $contactEmail, 'contactPhone' => $contactPhone], 201);
    }


    public function show($id)
    {
        $parc = Parc::with('user')->findOrFail($id);
        $contacts = Contact::where('parc_id', $parc->id)->get(); // Correction pour récupérer tous les contacts associés au parc

        return response()->json(['parc' => $parc, 'contacts' => $contacts], 200);
    }

    // public function getParcsByUser($userId)
    // {
    //     $parcs = Parc::with(['user', 'contacts'])
    //         ->where('user_id', $userId)
    //         ->get();

    //     return response()->json($parcs, 200);
    // }


    public function getParcsByUser($userId)
    {
        $parcs = Parc::with(['user', 'contacts', 'file'])
            ->where('user_id', $userId)
            ->get();

        // Ajouter l'URL de l'image pour chaque parc
        $parcs->each(function ($parc) {
            if ($parc->file) {
                $parc->file_url = asset('storage/uploads/' . $parc->file->file_name);
            }
        });

        return response()->json($parcs, 200);
    }


    public function uploadFile(Request $request, $parcId)
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

        $parc = Parc::findOrFail($parcId);
        $parc->file_id = $fileRecord->id;
        $parc->save();

        $fileUrl = asset('storage/uploads/' . $fileRecord->file_name);

        return response()->json(['url' => $fileUrl], 201);
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom_parc' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'nombre_batteries' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
            'emailEdit' => 'required|string|max:255|email',
            'phoneEdit' => 'required|string|max:255',
            'choixEmailEdit' => 'required|string|max:255',
            'choixPhoneEdit' => 'required|string|max:255',
            'idContactEmailEdit' => 'required|exists:contacts,id',
            'idContactPhoneEdit' => 'required|exists:contacts,id',
        ]);

        $parc = Parc::findOrFail($id);

        // Mise à jour des champs du parc
        $parc->nom_parc = $validatedData['nom_parc'];
        $parc->description = $validatedData['description'];
        $parc->adresse = $validatedData['adresse'];
        $parc->nombre_batteries = $validatedData['nombre_batteries'];
        $parc->user_id = $validatedData['user_id'];

        // Sauvegarde des modifications du parc
        $parc->save();

        // Mise à jour du contact email
        $contactEmail = Contact::findOrFail($validatedData['idContactEmailEdit']);
        $contactEmail->type = 'email';
        $contactEmail->choix = $validatedData['choixEmailEdit'];
        $contactEmail->valeur = $validatedData['emailEdit'];
        $contactEmail->parc_id = $parc->id;
        $contactEmail->save();

        // Mise à jour du contact téléphone
        $contactPhone = Contact::findOrFail($validatedData['idContactPhoneEdit']);
        $contactPhone->type = 'phone';
        $contactPhone->choix = $validatedData['choixPhoneEdit'];
        $contactPhone->valeur = $validatedData['phoneEdit'];
        $contactPhone->parc_id = $parc->id;
        $contactPhone->save();

        return response()->json(['message' => 'Modification réussie! 🎉'], 200);
    }


    public function destroy($id)
    {
        // Trouver le parc par ID
        $parc = Parc::findOrFail($id);

        // Supprimer les contacts associés
        Contact::where('parc_id', $parc->id)->delete();

        // Supprimer le parc
        $parc->delete();

        // Renvoyer une réponse vide avec le statut 204
        return response()->json(null, 204);
    }

}
