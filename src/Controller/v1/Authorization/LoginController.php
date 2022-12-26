<?php

namespace App\Controller\v1\Authorization;

use App\Controller\v1\AbstractController;
use App\Core\Persistence\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    #[Route(
        '/api/v1/authorization/login',
        name: 'v1_authorization_login'
    )]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (!$user) {
            return $this->error(
                'Invalid credentials',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = null; // TODO

        return $this->success([
            'id' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
