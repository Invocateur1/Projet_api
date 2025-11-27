<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     *@param Request $request
     *@return \Illuminate\Http\JsonResponse;
    */
    
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed',
        ],
        [
            'name.required'=>'Le nom est obligatoire',
            'email.required'=>'L\'email est obligatoire',
            'email.email'=>'L\'email doit être valide',
            'email.unique'=>'Cet email est déjà utilisé',
            'password.required'=>'Le mot de passe est obligatoire',
            'password.min'=>'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed'=>'Les mots de passe ne correspondent pas',
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=>'Erreurs de validation',
                'errors'=>$validator->errors()
            ],422);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $token=auth('api')->login($user);

        return response()->json([
            'success'=>true,
            'message'=>'Utilisateur enregistré avec succès',
            'data'=>[
                'user'=>[
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email,
                ],
                'authorization'=>[
                    'token'=>$token,
                    'type'=>'bearer',
                    'expires_in'=>auth('api')->factory()->getTTL()*60
                ]
            ]
        ],201);
    }
    /** 
    *@param Request $request
    *@return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            ],[
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'password.required' => 'Le mot de passe est obligatoire',
        ]);

        if($validator->fails()){
            return response()->json([
            'success' => false,
            'message' => 'Erreurs de validation',
            'errors' => $validator->errors()
            ],422);
        }
        $credentials=$request->only('email','password');
        
        if (!$token = auth('api')->attempt($credentials)){
            // Si les credentials sont incorrects
            return response()->json([
                'success' => false,
                'message' => 'Email ou mot de passe invalide',
            ], 401); // 401 Unauthorized
        }
        $user = auth('api')->user();

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60
                ]
            ]
        ], 200); // 200 OK
    }
    /**
        * Obtenir le profil de l'utilisateur authentifié
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => auth('api')->user() // Utilisateur actuellement connecté
            ]
        ], 200);
    }
    /**
        * Déconnecter l'utilisateur (invalider le token)
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        // Invalider le token JWT actuel
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
        ], 200);
    }
    /**
        * Rafraîchir le token JWT
        * Obtenir un nouveau token sans se reconnecter
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        // Générer un nouveau token
        $token = auth('api')->refresh();

        return response()->json([
            'success' => true,
            'data' => [
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60
                ]
            ]
        ], 200);
    }

}
