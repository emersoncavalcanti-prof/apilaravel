<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    function login(Request $request){
        
    $request->only([
        'email',
        'password'
    ]);

    $user = User::where('email', $request->email)->first();

    if(!$user || !Hash::check($request->password, $user->password)){
        return response()->json([
            'status' => 'error', 
            'message' => 'E-mail ou senha incorreto'],
             400);
    }
    

    $token = $user->createToken($request->email)->plainTextToken;

    return response()->json([
        'status' => 'success', 
        'user' => $user, 
        'token' => $token], 200);
    }

    function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout realizado com sucesso'
        ], 200);
    }

    function registro(Request $request) {
        
       try{
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
            ]); 

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);  
            
            $token = $user->createToken($request->email)->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response,Response::HTTP_OK);


       }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
       }

    }
}
