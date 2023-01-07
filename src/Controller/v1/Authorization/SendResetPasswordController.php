<?php

namespace App\Controller\v1\Authorization;

use App\Controller\v1\AbstractController;
use App\Core\UseCase\Authorization\SendResetPasswordEmailUseCase;
use App\Http\Request\v1\Authorization\SendResetPasswordRequest;
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
    public function index(SendResetPasswordRequest $request): Response
    {
        $this->sendResetPasswordEmailUseCase->run(
            $request->getEmail()
        );

        return $this->success();
    }
}
