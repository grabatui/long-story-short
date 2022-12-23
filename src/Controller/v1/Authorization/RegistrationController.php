<?php

namespace App\Controller\v1\Authorization;

use App\Controller\v1\AbstractController;
use App\Core\Domain\Registration\Entity\User;
use App\Core\UseCase\Registration\RegisterUserUseCase;
use App\Request\v1\Authorization\RegistrationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly RegisterUserUseCase $registerUserUseCase
    ) {
    }

    #[Route(
        '/api/v1/authorization/register',
        name: 'v1_authorization_register'
    )]
    public function index(RegistrationRequest $request): Response
    {
        $this->registerUserUseCase->run(
            new User(
                $request->getEmail(),
                $request->getName(),
                $request->getPassword()
            )
        );

        return $this->success();
    }
}
