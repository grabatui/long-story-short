<?php

namespace App\Security;

use App\Core\Persistence\Entity\Enum\UserRoleEnum;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

readonly class AdminAccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        if (in_array(UserRoleEnum::admin->value, $accessDeniedException->getAttributes())) {
            return new RedirectResponse(
                $this->urlGenerator->generate('admin_login')
            );
        }

        return new Response();
    }
}
