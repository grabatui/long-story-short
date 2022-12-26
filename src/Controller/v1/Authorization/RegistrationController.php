<?php

namespace App\Controller\v1\Authorization;

use App\Controller\v1\AbstractController;
use App\Core\Domain\Authorization\Entity\NewUser;
use App\Core\UseCase\Authorization\RegisterUserUseCase;
use App\Http\Request\v1\Authorization\RegistrationRequest;
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
            new NewUser(
                $request->getEmail(),
                $request->getName(),
                $request->getPassword()
            )
        );

        return $this->success();
    }
}
