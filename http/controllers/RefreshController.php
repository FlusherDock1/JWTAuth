<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use ReaZzon\JWTAuth\Classes\Actions\RefreshToken;
use ReaZzon\JWTAuth\Http\Resources\TokenResource;

/**
 *
 */
class RefreshController extends Controller
{
    /**
     * @return JsonResource
     */
    public function __invoke(RefreshToken $refreshTokenAction): JsonResource
    {
        $tokenDto = $refreshTokenAction->handle();
        return new TokenResource($tokenDto);
    }
}
