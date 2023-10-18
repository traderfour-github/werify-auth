<?php

namespace App\Http\Controllers;

use App\Concerns\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="Auth Service v1"
 * )
 *
 * @OA\PathItem(path="/api/v1")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponse;

    /**
     * Construct the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Add any required dependencies
    }

    /**
     * Format the response data.
     *
     * @param  bool  $data    The response data.
     * @param  string  $message Message returned by request
     * @param  array  $metas   Any messages to include.
     * @param  mixed  $succeed The response succeed.
     * @return array The formatted response data.
     */
    public function response($data = [], $message = '', $metas = [], $succeed = true, $statusCode = Response::HTTP_OK, $headers = [])
    {
        $this->setMessage($message);
        $this->hasErrors($succeed);
        $this->setMetas($metas);

        return $this->respond(is_array($data) ? $data : json_decode($data, true), $statusCode, $headers);
    }
}
