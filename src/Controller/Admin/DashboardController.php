<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Dossier;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(DossierCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('POC Symfony Webpack Bootstrap');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Categories', 'fas fa-bullhorn', Category::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-bullhorn', Client::class);
        yield MenuItem::linkToCrud('Dossiers', 'fas fa-bullhorn', Dossier::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToUrl('Symfony Doc', 'fas fa-code', 'https://symfony.com/doc/current/')->setLinkTarget('_blank');
        yield MenuItem::linkToRoute('Front End', 'fas fa-home', 'dossierList');
    }
}
