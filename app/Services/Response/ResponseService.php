<?php

namespace App\Services\Response;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ResponseService
{
    /**
     * @param array $errors
     * @return JsonResponse
     */
    public static function invalid($errors = [])
    {
        return response()->json([
            'type' => 'ERR_INVALID',
            'errors' => $errors
        ], 422);
    }

    /**
     * @param $msg
     * @param $code
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function errorMessage($msg, $code, $statusCode = 400)
    {
        return response()->json([
            'type' => 'ERR_MESSAGE',
            'error' => $code,
            'error_message' => $msg,
            'timestamp' => Carbon::now()->timestamp
        ], $statusCode);
    }

    /**
     * @param $msg
     * @return JsonResponse
     */
    public static function successMessage($msg)
    {
        return response()->json([
            'msg' => $msg
        ], 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public static function successNoContent()
    {
        return response('', 204);
    }

    /**
     * @param $data
     * @param $metadata
     * @return JsonResponse
     */
    public static function data($data, $metadata = null)
    {
        return response()->json([
            'data' => $data,
            'metadata' => $metadata,
        ], 200);
    }
}
