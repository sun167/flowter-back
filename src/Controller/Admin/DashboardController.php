<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\CarType;
use App\Entity\Company;
use App\Entity\Location;
use App\Entity\Model;
use App\Entity\Motive;
use App\Entity\Option;
use App\Entity\Ride;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
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
        $url = $adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Flowter Back')
            
            ->setFaviconPath('favicon.svg')

            // the domain used by default is 'messages'
            ->setTranslationDomain('my-custom-domain')

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')

            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            ->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
            //->renderSidebarMinimized()

            // by default, users can select between a "light" and "dark" mode for the
            // backend interface. Call this method if you prefer to disable the "dark"
            // mode for any reason (e.g. if your interface customizations are not ready for it)
            ->disableDarkMode()

            // by default, all backend URLs are generated as absolute URLs. If you
            // need to generate relative URLs instead, call this method
            ->generateRelativeUrls()

            // set this option if you want to enable locale switching in dashboard.
            // IMPORTANT: this feature won't work unless you add the {_locale}
            // parameter in the admin dashboard URL (e.g. '/admin/{_locale}').
            // the name of each locale will be rendered in that locale
            // (in the following example you'll see: "English", "Polski")
            ->setLocales(['en', 'pl'])
            // to customize the labels of locales, pass a key => value array
            // (e.g. to display flags; although it's not a recommended practice,
            // because many languages/locales are not associated to a single country)
            // ->setLocales([
            //     'en' => '🇬🇧 English',
            //     'fr' => '🇵🇱 Francais'
            // ])
            // to further customize the locale option, pass an instance of
            // EasyCorp\Bundle\EasyAdminBundle\Config\Locale
            // ->setLocales([
            //     'en', // locale without custom options
            //     Locale::new('pl', 'polski', 'far fa-language') // custom label and icon])
            ;
    }

    public function configureMenuItems(): iterable
    {
        // return [
        yield MenuItem::section('Blog');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
       

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('List of users', 'fa fa-user', User::class);

        yield MenuItem::section("Companies");
        yield MenuItem::linkToCrud('List of companies', 'fa fa-building', Company::class)->setPermission("ROLE_ADMIN");
        yield MenuItem::linkToCrud('Locations', 'fas fa-map-marker', Location::class)->setPermission("ROLE_ADMIN");

        yield MenuItem::section("Cars");
        yield MenuItem::linkToCrud('List of cars', 'fas fa-car', Car::class);
        yield MenuItem::linkToCrud('Types of car', 'fas fa-question', CarType::class);
        yield MenuItem::linkToCrud('Brands', 'fas fa-star', Brand::class);
        yield MenuItem::linkToCrud('Models', 'fas fa-cube', Model::class);
        yield MenuItem::linkToCrud('Car options', 'fas fa-cog', Option::class);

        yield MenuItem::section("Reservations");
        yield MenuItem::linkToCrud('Rides', 'fas fa-file-alt', Ride::class);
        yield MenuItem::linkToCrud('Motives', 'fas fa-flag', Motive::class);

        // ];
    }
}
