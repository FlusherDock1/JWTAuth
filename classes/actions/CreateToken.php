<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Actions;

use Illuminate\Database\Eloquent\Model;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;

/**
 * Class CreateToken.
 * @package ReaZzon\JWTAuth\Classes\Actions
 */
class CreateToken extends TokenAction
{
    /**
     * @param Model $userModel
     * @return TokenDto
     */
    public function handle(Model $userModel): TokenDto
    {
        $this->userPluginResolver->getGuard()->login($userModel);
        return TokenDto::createByJWTGuard($this->userPluginResolver->getGuard());
    }
}
