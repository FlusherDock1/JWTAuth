<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use ReaZzon\JWTAuth\Classes\Actions\Logout;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class LogoutController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(Logout $logoutAction): Response
    {
        $logoutAction->handle();
        return new Response([], Response::HTTP_NO_CONTENT);
    }
}
