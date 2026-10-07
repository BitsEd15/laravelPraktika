<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NewAuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $reqData = $request->validated();
        // $user = User::where('email','=',$reqData['email'])->first();
        // $user = DB::table('users')
        //         ->select('*')
        //         ->where('email','=',$reqData['email'])->first();//он возвращает  стандартный PHP-объект (stdClass), а не модель User. У объекта этого нет модели
        $user = User::where(['email'=> $reqData['email']])->first();//Метод createToken() существует только у объекта модели. Если  получиnь пользователя через Eloquent, можно вызвать $user->createToken().
        if (!$user || !Hash::check($reqData['password'], $user->password)) {
            return response()->json([
                'error' => 'Неверные учетные данные!'
            ], 401);
            }
            $token = $user->createToken('dorm_token')->plainTextToken;
            return response()->json([
                'message'=>'успех',
                'token'=>$token,
            ],200);
}
}