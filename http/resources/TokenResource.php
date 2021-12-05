<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Resources;

/**
 * TokenResource in response
 */
class TokenResource extends ExtendableResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request): array
    {
        return [
            'token' => $this->resource->token,
            'expires' => $this->resource->expires,
            'user' => new UserResource($this->resource->user),
        ];
    }
}
