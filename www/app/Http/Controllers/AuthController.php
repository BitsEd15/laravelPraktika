<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            "name"=>['required'],
            "email"=>['required','unique:users,email'],
            "password"=>['required','string']
        ]);
        $validated["password"]=Hash::make($validated["password"]); // ъх как сделать это внутри validated
        $user = User::create($validated);
        $token = $user->createToken('sign_up_token');

        return response()->json([
            'message'=>'succes',
            'token'=>$token->plainTextToken// а можешь объяснить зачем расшифрововывать токен? 
        ],201);
    }

    public function signIn(Request $request)
    {
        $validated = $request->validate([
            "email"=>['required','email'],//хз что тут еще нужно бля
            "password"=>['required','string']
        ]);

        $user = User::where([
            'email'=> $validated['email'],
        ])->first();

        if(!$user)
            return response()->json([
            'error'=>'Неверные учетные данные!'
        ],401);

        if (Hash::check($validated['password'], $user->password))
            $token = $user->createToken('sign_up_token');
        else
            return response()->json([
            'error'=>'Неверный пароль!'
        ],401);
        return response()->json([
            'message'=>'succes',
            'user'=>$user,
            'token'=>$token->plainTextToken
        ],200);
    }
    public function logOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'Успешно разлогинился',
        ],200);
    }
}
