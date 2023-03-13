<?php

namespace App\Core\Presentation\Controller\v1\Authorization;

use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Request\v1\Authorization\ChangePasswordRequest;
use App\Core\UseCase\Authorization\ChangePasswordWithTokenUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    public function __construct(
        private readonly ChangePasswordWithTokenUseCase $changePasswordWithTokenUseCase
    ) {
    }

    #[Route(
        '/api/v1/authorization/change_password',
        name: 'v1_authorization_change_password',
        methods: ['POST']
    )]
    public function __invoke(ChangePasswordRequest $request): Response
    {
        $this->changePasswordWithTokenUseCase->run(
            $request->getResetToken(),
            $request->getPassword()
        );

        return $this->success();
    }
}
