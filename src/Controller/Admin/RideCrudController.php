<?php

namespace App\Controller\Admin;

use App\Entity\Ride;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ride::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
