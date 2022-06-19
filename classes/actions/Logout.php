<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Actions;

use Illuminate\Database\Eloquent\Model;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;

/**
 * Class Logout.
 * @package ReaZzon\JWTAuth\Classes\Actions
 */
class Logout extends TokenAction
{
    /**
     * @return bool
     */
    public function handle(): void
    {
        if (!$this->userPluginResolver->getGuard()->check()) {
            return;
        }

        $this->userPluginResolver->getProvider()->logout();
        $this->userPluginResolver->getGuard()->logout();
    }
}
