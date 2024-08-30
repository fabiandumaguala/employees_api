<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\Signup_User_Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'signup']]);
        $this->middleware('jwt.auth', ['except' => ['login', 'signup', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Correo electrónico o contraseña no existen.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Create a JWT via new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Signup_User_Request $request)
    {
        $user = new User($request->all());
        $user->save();
        return $this->login($user);
    }

     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user();
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        try {
            return $this->respondWithToken(auth('api')->refresh());
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Token has expired and can no longer be refreshed'
            ], 400);
        }

        //return $this->respondWithToken(Auth::guard('api')->refresh());


      //return $this->respondWithToken(auth()->refresh());
    }

     /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => auth()->user()->name,
            'email'         => auth()->user()->email,
        ]);
    }
}
