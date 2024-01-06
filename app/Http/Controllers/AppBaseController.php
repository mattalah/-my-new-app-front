<?php

namespace App\Http\Controllers;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="artiEye api",
 *      description="artiEye api documentation",
 *      @OA\Contact(
 *          email="saifeddinne.mattalah@gmail.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\SecurityScheme(
 *   securityScheme="token",
 *   type="http",
 *   name="bearerAuth",
 *   in="header",
 *   scheme="bearer",
 * )
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200)
    {
        return response()->json([
            'result' => $result,
            'message' => $message,
        ], $code);
    }

    public function sendError($message, $code = 404, $data = [])
    {
        return response()->json([
            'errors' => $data,
            'message' => $message,
            'data' => [],
        ], $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}