<?php

namespace App\Controller\v1\Authorization;

use App\Controller\v1\AbstractController;
use App\Core\Persistence\Entity\User;
use App\Core\UseCase\Authorization\CreateUserTokenUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly CreateUserTokenUseCase $createUserTokenUseCase
    ) {
    }

    #[Route(
        '/api/v1/authorization/login',
        name: 'v1_authorization_login'
    )]
    public function __invoke(#[CurrentUser] ?User $user): Response
    {
        if (!$user) {
            return $this->error(
                'Invalid credentials',
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->success([
            'id' => $user->getId(),
            'token' => $this->createUserTokenUseCase->run(
                $user->getId()
            ),
        ]);
    }
}
