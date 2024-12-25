<?php

namespace App\Contexts\User\Infrastructure\Http\Controllers;

use App\Base\BaseApiController;
use App\Contexts\User\Application\UserService;
use App\Contexts\User\Infrastructure\Http\Requests\LoginUserRequest;
use App\Contexts\User\Infrastructure\Http\Requests\RegisterUserRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 */
class AuthApiController extends BaseApiController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     description="Register a new user with name, email, password, and role.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="role", type="string", example="member", description="User role, e.g., member or librarian")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string", example="JWT Token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input data")
     *         )
     *     )
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        $role = $request->input('role', 'member');

        $result = $this->userService->registerUser(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
            $role
        );

        return response()->json([
            'user' => $result['user'],
            'token' => $result['token']
        ], ResponseAlias::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login a user",
     *     description="Authenticate user with email and password to receive a JWT token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="JWT Token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid Credentials")
     *         )
     *     )
     * )
     */
    public function login(LoginUserRequest $request)
    {
        $token = $this->userService->loginUser(
            $request->input('email'),
            $request->input('password')
        );

        if (!$token) {
            return response()->json(['error' => 'Invalid Credentials'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Authentication"},
     *     summary="Get user profile",
     *     description="Retrieve the authenticated user's profile information.",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not authenticated")
     *         )
     *     )
     * )
     */
    public function profile()
    {
        $userEntity = $this->userService->getProfile();
        if (!$userEntity) {
            return response()->json(['error' => 'Not authenticated'], ResponseAlias::HTTP_UNAUTHORIZED);
        }
        return response()->json($userEntity);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Logout a user",
     *     description="Invalidate the current JWT token.",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not authenticated")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        $this->userService->logoutUser();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
