<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;


class ContactController extends Controller
{
    // Afficher tous les contacts
    public function index()
    {
        $contacts = Contact::with('parc')->get();
        return response()->json($contacts, 200);
    }

    // Afficher un contact spécifique
    public function show($id)
    {
        $contact = Contact::with('parc')->findOrFail($id);
        return response()->json($contact, 200);
    }

    // Créer un nouveau contact
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'choix' => 'required|string|max:255',
            'valeur' => 'required|string|max:255',
            'parc_id' => 'required|exists:parcs,id'
        ]);

        $contact = Contact::create($validatedData);
        return response()->json($contact, 201);
    }

    // Mettre à jour un contact
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'sometimes|required|string|max:255',
            'choix' => 'sometimes|required|string|max:255',
            'valeur' => 'sometimes|required|string|max:255',
            'parc_id' => 'sometimes|required|exists:parcs,id'
        ]);

        $contact->update($validatedData);
        return response()->json($contact, 200);
    }

    // Supprimer un contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }

        // Récupérer les contacts par parc_id
    public function getByParcId($parc_id)
    {
        // Vérifiez si le parc existe
        $contacts = Contact::where('parc_id', $parc_id)->with('parc')->get();

        // Si aucun contact n'est trouvé, renvoyez une erreur 404
        if ($contacts->isEmpty()) {
            return response()->json(['message' => 'Aucun contact trouvé pour ce parc'], 404);
        }

        return response()->json($contacts, 200);
    }

}
