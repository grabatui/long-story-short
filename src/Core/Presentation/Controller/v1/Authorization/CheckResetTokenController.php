<?php

namespace App\Core\Presentation\Controller\v1\Authorization;

use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Provider\Authorization\ResetTokenProvider;
use App\Core\Presentation\Request\v1\Authorization\CheckResetTokenRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckResetTokenController extends AbstractController
{
    public function __construct(
        private readonly ResetTokenProvider $resetTokenProvider
    ) {
    }

    #[Route(
        '/api/v1/authorization/check_reset_token',
        name: 'v1_authorization_check_reset_token'
    )]
    public function __invoke(CheckResetTokenRequest $request): Response
    {
        $resetToken = $request->getResetToken();

        if (!$this->resetTokenProvider->isResetTokenValid($resetToken)) {
            return $this->error('Токен не валиден', Response::HTTP_BAD_REQUEST);
        }

        return $this->success();
    }
}
