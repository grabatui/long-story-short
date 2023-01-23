<?php

namespace App\Core\Presentation\Controller\v1\Authorization;

use App\Core\Presentation\Controller\v1\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    #[Route(
        '/api/v1/authorization/logout',
        name: 'v1_authorization_logout'
    )]
    public function __invoke(): Response
    {
        // Exists only for default security work
        throw new \RuntimeException('What are you doing here?');
    }
}
