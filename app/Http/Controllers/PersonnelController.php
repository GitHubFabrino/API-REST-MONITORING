<?php

namespace App\Http\Controllers;

use App\Models\Parc;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    //
    // Méthode pour récupérer tout le personnel associé à un parc spécifique
    public function getPersonnelByParc($parcId)
    {
        // Trouver le parc par ID
        $parc = Parc::with('personnel')->find($parcId);

        if (!$parc) {
            return response()->json(['message' => 'Parc non trouvé'], 404);
        }

        // Retourner le personnel associé au parc
        return response()->json($parc->personnel);
    }




    public function getUsersByParc($parcId)
    {
        // Trouver le parc par ID avec les utilisateurs associés, leurs rôles et fichiers
        $parc = Parc::with(['personnel.roles', 'personnel.file'])->find($parcId);

        if (!$parc) {
            return response()->json(['message' => 'Parc non trouvé'], 404);
        }

        // Remplacer le file_name par l'URL complète de l'image pour chaque utilisateur
        $parc->personnel->each(function ($user) {
            if ($user->file) {
                $user->file->file_name = asset('storage/uploads/' . $user->file->file_name);
            }
        });

        // Retourner les utilisateurs associés au parc avec leurs rôles et fichiers
        return response()->json($parc->personnel);
    }


    public function updateUser(Request $request, $id)
    {
        // Valider les données entrantes
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'adresse' => 'required|string|max:255',
        ]);
    
        // Trouver l'utilisateur par ID ou échouer si non trouvé
        $user = User::findOrFail($id);
    
        // Mettre à jour les champs de l'utilisateur
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->adresse = $validatedData['adresse'];
    
        // Sauvegarder les modifications
        $user->save();
    
        // Retourner une réponse JSON de succès
        return response()->json(['message' => 'Modification réussie! 🎉'], 200);
    }

    public function createUserTechnicien(Request $request)
    {
        // Valider les données entrantes
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'required|string|max:255',
            'parc_id' => 'required|exists:parcs,id', // Assurez-vous que parc_id est fourni et existe dans la table parcs
        ]);
    
        // Créer un nouvel utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['email']),
            'username' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'adresse' => $validatedData['adresse'],
            'nom_photo_profile' => $validatedData['name'],
        ]);
    
        // Trouver le rôle "technicien"
        $technicienRole = Role::where('name', 'Technicien')->first();
    
        // Attacher le rôle "technicien" à l'utilisateur
        if ($technicienRole) {
            $user->roles()->attach($technicienRole->id);
        }
    
        // Attacher l'utilisateur au parc
        $parc = Parc::find($validatedData['parc_id']);
        if ($parc) {
            $parc->personnel()->attach($user->id);
        }
    
        // Retourner une réponse JSON avec les informations de l'utilisateur
        return response()->json(['user' => $user], 201);
    }

    public function deleteUser($id)
    {
        // Trouver l'utilisateur par ID
        $user = User::findOrFail($id);
    
        // Détacher l'utilisateur de tous les rôles
        $user->roles()->detach();
    
        // Détacher l'utilisateur de tous les parcs
        $user->parcs()->detach();
    
        // Supprimer l'utilisateur
        $user->delete();
    
        // Retourner une réponse JSON indiquant le succès de la suppression
        return response()->json(['message' => 'Utilisateur supprimé avec succès! ✅'], 200);
    }
    
    
    




}
