<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Health Information System API",
 *     version="1.0.0",
 *     description="API documentation for the Health Information System"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Enter your Bearer token in the format **Bearer &lt;token&gt;**"
 * )
 */
class ApiDocController extends Controller
{
}
