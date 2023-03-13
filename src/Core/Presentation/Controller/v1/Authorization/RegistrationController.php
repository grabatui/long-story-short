<?php

namespace App\Core\Presentation\Controller\v1\Authorization;

use App\Core\Domain\Authorization\Entity\NewUser;
use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Request\v1\Authorization\RegistrationRequest;
use App\Core\UseCase\Authorization\RegisterUserUseCase;
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
        name: 'v1_authorization_register',
        methods: ['POST']
    )]
    public function __invoke(RegistrationRequest $request): Response
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
