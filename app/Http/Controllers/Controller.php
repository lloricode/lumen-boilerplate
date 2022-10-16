<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Transformers\BaseTransformer;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\Fractal\Serializer\JsonApiSerializer;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *     title=SWAGGER_LUME_TITLE,
     *     description="RESTful API template made from lumen",
     *     version="1.0",
     *     @OA\Contact(
     *         email="lloricode@gmail.com",
     *         name="Lloric Mayuga Garcia"
     *     ),
     *     @OA\License(
     *         name="MIT",
     *         url="https://opensource.org/licenses/MIT"
     *     )
     * )
     * @OA\Server(
     *     url=SWAGGER_LUME_CONST_HOST,
     *     description="API Server"
     * )
     * @OA\Post(
     *     path="/oauth/token",
     *     summary="Generate access token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="grant_type",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="client_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="client_secret",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={
     *                     "grant_type" : "password",
     *                     "client_id" : "2",
     *                     "client_secret" : "BZnwQmjc0LEi40jVKoW2ICX2LC1K4mG0NKfWBl8Z",
     *                     "username" : "system@system.com",
     *                     "password" : "secret"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="token_type",
     *                         type="string",
     *                         description="Bearer"
     *                     ),
     *                     @OA\Property(
     *                         property="expires_in",
     *                         type="integer",
     *                         description="Token expiration in miliseconds",
     *                         @OA\Items
     *                     ),
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         description="JWT access token"
     *                     ),
     *                     @OA\Property(
     *                         property="refresh_token",
     *                         type="string",
     *                         description="Token type"
     *                     ),
     *                     example={
     *                         "token_type" : "bearer",
     *                         "expires_in" : 3600,
     *                         "access_token" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJ...",
     *                         "refresh_token" : "def50200b10ed22a1dab8bb0d18..."
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     *
     * @OA\Tag(
     *     name="Authentication",
     *     description="API Endpoints of Authentication"
     * )
     * @OA\Tag(
     *     name="Authorization",
     *     description="API Endpoints of Authorization"
     * )
     * @OA\Tag(
     *     name="Localizations",
     *     description="API Endpoints of Localizations"
     * )
     * @OA\Tag(
     *     name="Access",
     *     description="API Endpoints of Access"
     * )
     *
     * @OA\Schema(
     *     schema="Error",
     *     required={"message"},
     *     @OA\Property(
     *         property="message",
     *         type="string"
     *     )
     * ),
     */

    /**
     * @param $data
     * @param  \App\Transformers\BaseTransformer  $transformer
     *
     * @return \Spatie\Fractal\Fractal
     */
    protected function fractal($data, BaseTransformer $transformer)
    {
        return fractal($data, $transformer, JsonApiSerializer::class)
            ->withResourceName($transformer->getResourceKey())
            ->addMeta(['include' => $transformer->getAvailableIncludes()]);
    }
}
