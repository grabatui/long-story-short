<?php

namespace App\Core\Presentation\Controller\v1\Authorization;

use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Request\v1\Authorization\SendResetPasswordRequest;
use App\Core\UseCase\Authorization\SendResetPasswordEmailUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SendResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly SendResetPasswordEmailUseCase $sendResetPasswordEmailUseCase
    ) {
    }

    #[Route(
        '/api/v1/authorization/restore_password',
        name: 'v1_authorization_restore_password'
    )]
    public function __invoke(SendResetPasswordRequest $request): Response
    {
        $this->sendResetPasswordEmailUseCase->run(
            $request->getEmail()
        );

        return $this->success();
    }
}
