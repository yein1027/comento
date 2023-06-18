<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use InfyOm\Generator\Utils\ResponseUtil;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    public function sendResponse($result, $message): JsonResponse
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, $code = 200): JsonResponse
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
