<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller

{


        /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="registerUser",
     *      tags={"Authentications"},
     *      summary="Register new user",
     *      description="Returns new user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'email' => 'required|unique:users',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => $validator->errors()->first(),
                ], 200);

            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);

                if ($user) {
                    return response()->json([
                        'status' => true,
                        'message' => 'User Account created successfully',
                        'user' => User::find($user->id),
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'error' => 'Registration failed',
                    ], 200);
                }
            }
        } catch (\Exception$exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());
            return response()->json([
                'status' => false,
                'error' => $exception->getMessage(),
                'message' => 'Registration failed',
            ], 200);
        }
    }



    
        /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="loginUser",
     *      tags={"Authentications"},
     *      summary="Login new user",
     *      description="Returns new user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginUserRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first(),
            ], 401);
        } else {
            if (Auth::attempt($credentials)) {
//
                $user = User::with('roles','permissions')->find(Auth::id());
                $token = $user->createToken($user->id)->plainTextToken;
                return response()->json([
                    'status' => true,
                    'token' => $token,
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Please check your credentials',
                ], 401);
            }
        }
    }
}
