<?php

namespace App\Controller\Admin;

use App\Entity\CarType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarType::class;
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
