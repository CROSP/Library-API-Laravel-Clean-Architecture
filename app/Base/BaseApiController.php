<?php

namespace App\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Library API Documentation",
 *      description="API Documentation for the Library Application",
 *      @OA\Contact(
 *          email="alexander@crosp.net"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Production Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="Bearer",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="Enter JWT token in the format **Bearer &lt;token&gt;**"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"id", "name", "email", "role"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="role", type="string", example="member"),
 * )
 *
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     required={"id", "title", "publisher", "author", "genre", "publication_date", "pages", "price"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="The Great Gatsby"),
 *     @OA\Property(property="publisher", type="string", example="Scribner"),
 *     @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
 *     @OA\Property(property="genre", type="string", example="Fiction"),
 *     @OA\Property(property="publication_date", type="string", format="date", example="1925-04-10"),
 *     @OA\Property(property="pages", type="integer", example=180),
 *     @OA\Property(property="price", type="number", format="float", example=15.99)
 * )
 */
class BaseApiController extends Controller
{
    /**
     * Return a successful JSON response.
     *
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithData($data, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
        ], $status);
    }

    /**
     * Return a created JSON response.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated($data): JsonResponse
    {
        return $this->respondWithData($data, 201);
    }

    /**
     * Return an unauthorized JSON response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error'   => [
                'code'    => 401,
                'message' => $message,
            ],
        ], 401);
    }

    /**
     * Return a forbidden JSON response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error'   => [
                'code'    => 403,
                'message' => $message,
            ],
        ], 403);
    }

    /**
     * Return a not found JSON response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error'   => [
                'code'    => 404,
                'message' => $message,
            ],
        ], 404);
    }

    /**
     * Return a general error JSON response.
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error'   => [
                'code'    => $status,
                'message' => $message,
            ],
        ], $status);
    }
}
