<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper 
{
    /**
     * Api response for server error
     * @param $e
     */
    public static function serverError($e)
    {
        return response()->json([
            'status' => false,
            'status_code' => 500,
            'message' => 'Server Error',
            'error_message' => $e->getMessage(),
            'error_line' => $e->getLine(),
            'error_file' => $e->getFile()
        ], 500);
    }

    /**
     * returning other response
     * @param bool $status
     * @param int $code
     * @param string $message
     * @param $data
     * @param int $responseStatus
     * @return JsonResponse
     */
    public static function otherResponse(bool $status = true, int $code = 200, string $message = '', $data = [], int $responseHeaderCode = 200)
    {
        return response()->json([
            'status' => $status,
            'status_code' => $code,
            'message' => $message,
            'data' => $data
        ], $responseHeaderCode);
    }

    /**
     * Error response
     * @param $message
     */
    public static function errorResponse(string $message)
    {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => $message,
            'data' => []
        ], 400);
    }

    /**
     * Untuthenticate response
     * @return JsonResponse
     */
    public static function unauthenticateResponse() :JsonResponse
    {
        return response()->json([
            'status' => false,
            'status_code' => 401,
            'message' => trans('messages.Unauthenticated'),
            'data' => []
        ], 401);
    }
}