<?php

namespace App\Core\Presentation\Controller\Admin;

use App\Core\Persistence\Entity\Enum\UserRoleEnum;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(
        path: '/admin/login',
        name: 'admin_login'
    )]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $isAccessDenied = (
            !$error
            && $this->getUser()
            && !in_array(UserRoleEnum::admin->value, $this->getUser()->getRoles())
        );

        return $this->render(
            'admin/login.twig',
            ['last_username' => $lastUsername, 'error' => $error, 'isAccessDenied' => $isAccessDenied]
        );
    }

    #[Route(
        path: '/admin/logout',
        name: 'admin_logout'
    )]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
