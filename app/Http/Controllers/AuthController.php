<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints related to user authentication"
 * )
 */
class AuthController extends Controller
{
/**
     * @OA\Post(
     *      path="/api/register",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      operationId="register",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="John Doe",
     *                      description="User's name"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="john.doe@example.com",
     *                      description="User's email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      example="password123",
     *                      description="User's password"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User registered successfully"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function register(Request $request)
    {

        // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);

        // User Model
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
    }
/**
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Auth"},
     *      summary="Log in a user",
     *      operationId="login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="john.doe@example.com",
     *                      description="User's email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      example="password123",
     *                      description="User's password"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User logged in successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="User logged in successfully"),
     *              @OA\Property(property="token", type="string", example="your_jwt_token"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Invalid Credentials"),
     *          )
     *      )
     * )
     */
    public function login(Request $request)
    {

        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if (!empty($token)) {

            return response()->json([
                "status" => true,
                "message" => "User logged in succcessfully",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid Credentials"
        ]);
    }
/**
     * @OA\Post(
     *      path="/api/logout",
     *      tags={"Auth"},
     *      summary="Log out a user",
     *      operationId="logout",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="User logged out successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="User logged out successfully"),
     *          )
     *      )
     * )
     */
    public function logout()
    {

        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }
}
