<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valide les données du formulaire 
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'username' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
        ]);
        // Trouve l'utilisateur par son ID 
        $user = User::findOrFail($id);
        // Mets à jour les champs
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->username = $validatedData['username'];
        $user->phone = $validatedData['phone'];
        $user->adresse = $validatedData['adresse'];
        
        // Sauvegarde les modifications 
        $user->save();
        // Renvoie une réponse JSON avec les données mises à jour 
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'password' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'adresse' => 'required',
            'nom_photo_profile' => 'required',
            'validation_compte' => 'required',
            // 'date_inscription'=>'required',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'phone' => $validatedData['phone'],
            'adresse' => $validatedData['adresse'],
            'nom_photo_profile' => $validatedData['nom_photo_profile'],
            'password' => bcrypt($validatedData['password']),
            'validation_compte' => $validatedData['validation_compte'],
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$token = JWTAuth::attempt($validatedData)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }
    public function profil()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }
}
