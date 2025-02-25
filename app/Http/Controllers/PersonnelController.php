<?php

namespace App\Http\Controllers;

use App\Models\Parc;
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

    //  public function getUsersByParc($parcId)
    //  {
    //      // Trouver le parc par ID avec les utilisateurs associés
    //      $parc = Parc::with('personnel')->find($parcId);
 
    //      if (!$parc) {
    //          return response()->json(['message' => 'Parc non trouvé'], 404);
    //      }
 
    //      // Retourner les utilisateurs associés au parc
    //      return response()->json($parc->personnel);
    //  }


    //  public function getUsersByParc($parcId)
    // {
    //     // Trouver le parc par ID avec les utilisateurs associés et leurs rôles
    //     $parc = Parc::with('personnel.roles')->find($parcId);

    //     if (!$parc) {
    //         return response()->json(['message' => 'Parc non trouvé'], 404);
    //     }

    //     // Retourner les utilisateurs associés au parc avec leurs rôles
    //     return response()->json($parc->personnel);
    // }


    // public function getUsersByParc($parcId)
    // {
    //     // Trouver le parc par ID avec les utilisateurs associés, leurs rôles et fichiers
    //     $parc = Parc::with('personnel.roles', 'personnel.file')->find($parcId);

    //     if (!$parc) {
    //         return response()->json(['message' => 'Parc non trouvé'], 404);
    //     }

    //     // Retourner les utilisateurs associés au parc avec leurs rôles et fichiers
    //     return response()->json($parc->personnel);
    // }


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

}
