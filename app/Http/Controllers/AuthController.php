<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function listeUsers(){
        try {
            $users = User::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des users récupérée avec succès',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des users',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    /* Login API */
    public function login(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['erreur' => 'Email ou mot de passe incorrect'], 500);
        }
        return $this->createNewToken($token);

    }

    /* Register API */
    public function register(Request $request){

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);


        $user = new User();
        $user->setAttribute('nom', $request->nom);
        $user->setAttribute('prenom', $request->prenom);
        $user->setAttribute('email', $request->email);
        $user->setAttribute('telephone', $request->telephone);
        $user->setAttribute('password', Hash::make($request->password));
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
        ]);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Vous êtes déconnectée avec succès']);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
}
