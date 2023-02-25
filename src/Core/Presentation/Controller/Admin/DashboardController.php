<?php

namespace App\Core\Presentation\Controller\Admin;

use App\Core\Persistence\Entity\Movie;
use App\Core\Persistence\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route(
        '/admin',
        name: 'admin'
    )]
    public function __invoke(): Response
    {
        $url = $this->adminUrlGenerator->setController(MovieCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Панель администрирования');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Дашборд', 'fa fa-home');

        yield MenuItem::linkToUrl('На сайт', 'fas fa-home', '/');

        yield MenuItem::section('Основные сущности');
        yield MenuItem::linkToCrud('Фильмы', 'fas fa-film', Movie::class);

        yield MenuItem::section('Пользователи');
        yield MenuItem::linkToCrud('Пользователи', 'fas fa-user', User::class);
    }
}
