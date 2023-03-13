<?php

namespace App\Core\Presentation\Controller\v1\User;

use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Formatter\v1\User\GetInitFormatter;
use App\Core\Presentation\Provider\Authorization\UserProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetInitController extends AbstractController
{
    public function __construct(
        private readonly UserProvider $userProvider,
        private readonly GetInitFormatter $getInitFormatter
    ) {
    }

    #[Route(
        '/api/v1/user/init',
        name: 'v1_user_init',
        methods: ['GET']
    )]
    public function __invoke(): Response
    {
        $user = $this->userProvider->getAuthorizedInit();

        return $this->success(
            $this->getInitFormatter->format($user)
        );
    }
}
