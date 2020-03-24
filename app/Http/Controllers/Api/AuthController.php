<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => User::where('email', $credentials['email'])->get()->first()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
            ], 422);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh() {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);

            return response()->json([
                'success' => true,
                'token' => $token
            ], 200);

        } catch (TokenExpiredException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Token expirado, por favor inicie sesión nuevamente',
                'token' => $token
            ], 422);

        } catch (TokenBlacklistedException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Token blacklisted, por favor inicie sesión nuevamente',
                'token' => $token
            ], 422);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout()
    {
        $token = JWTAuth::getToken();

        try {
            JWTAuth::invalidate($token);
            return  response()->json([
                'success' => true,
                'message' => 'Cierre de sesión exitoso.'
            ], 200);
        } catch (JWTException  $exception) {
            return  response()->json([
                'success' => false,
                'message' => 'Cierre de sesión fallido, por favor intenta de nuevo.'
            ], 422);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
