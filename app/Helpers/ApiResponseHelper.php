<?php

namespace App\Helpers;

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
            'message' => 'Server Error'
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
    public static function otherResponse(bool $status = true, int $code = 200, string $message = '', $data = [], int $responseStatus = 200)
    {
        return response()->json([
            'status' => $status,
            'status_code' => $code,
            'message' => $message,
            'data' => $data
        ], $responseStatus);
    }
}