<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Resources;

/**
 * TokenResource in response
 */
class TokenResource extends ExtandableResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'token'   => $this->resource->token,
            'expires' => $this->resource->expires,
            'user'    => new UserResource($this->resource->user),
        ];
    }
}
