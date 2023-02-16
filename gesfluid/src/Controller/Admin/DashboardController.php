<?php

namespace App\Controller\Admin;

use App\Entity\Container;
use App\Entity\Accessory;
use App\Entity\Equipment;
use App\Entity\Fluid;
use App\Entity\FluidType;
use App\Entity\Group;
use App\Entity\Intervention;
use App\Entity\InterventionType;
use App\Entity\Parameter;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
      $routeBuilder = $this->container->get(AdminUrlGenerator::class);
      $url = $routeBuilder->setController(InterventionCrudController::class)->generateUrl();
      return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gesfluid')
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
      yield MenuItem::linkToUrl('Home', 'fas fa-home', '/');
      yield MenuItem::linkToCrud('Interventions', 'fas fa-screwdriver-wrench', Intervention::class);
      yield MenuItem::linkToCrud('Types d\'Interventions', 'fas fa-toolbox', InterventionType::class);
      yield MenuItem::linkToCrud('Equipements', 'fas fa-gears', Equipment::class);
      yield MenuItem::linkToCrud('Contenants', 'fas fa-bottle-droplet', Container::class);
      yield MenuItem::linkToCrud('Fluides', 'fas fa-droplet', Fluid::class);
      yield MenuItem::linkToCrud('Types de fluides', 'fas fa-eye-dropper', FluidType::class);
      yield MenuItem::linkToCrud('Accessoires', 'fas fa-compass', Accessory::class);
      yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
      yield MenuItem::linkToCrud('Groupes d\'utilisateurs', 'fas fa-user-group', Group::class);
      yield MenuItem::linkToCrud('Paramètres', 'fas fa-gear', Parameter::class);
    }
}
