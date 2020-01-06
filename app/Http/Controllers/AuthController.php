<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Token;
use App\Tools\Bearer;

class AuthController extends Model
{

    public function login(Request $request) 
    {
        try {

            $user = User::where("email", $request->email)->firstOrFail();

            if (\Hash::check($request->password, $user->password)) {
                // generar token
                $token = Token::create([
                    "token" => bcrypt($user->email),
                    "type" => "bearer",
                    "is_revoked" => 0,
                    "user_id" => $user->id,
                    "user_agent" => $request->header('user-agent')
                ]);
                // response
                return [
                    "success" => true,
                    "message" => "Usuario autenticado correctamente!",
                    "token" => $token->token,
                ];
            }
            // ejecutar error
            throw new Error('');
        } catch (\Throwable $th) {
            // response cuando la contraseña es incorrecta
            return [
                "success" => false,
                "message" => "Las credenciales de acceso son incorretas!",
                "token" => null,
            ];
        }
    }


    public function logout(Request $request)
    {
        try {
            $token = Bearer::getToken();

            $newToken = Token::where('token', $token)->where("is_revoked", 0)->firstOrFail();
            $newToken->update([ "is_revoked" => 1 ]);
            // response
            return [
                "success" => true,
                "message" => "La sesión se cerró correctamente!"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => "No se pudó cerrar la sesión!"
            ];
        }
    }


    public function me()
    {
        try {
            $token = Bearer::getToken();
            $user = User::whereHas('tokens', function($tok) use($token) {
                $tok->where("is_revoked", 0)
                    ->where("token", $token);
            })->firstOrFail();
            // response
            return [
                "user" => $user,
            ];
        } catch (\Throwable $th) {
            return [
                "user" => null
            ];
        }
    }

}
