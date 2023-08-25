<?php

namespace App\Controller\Admin;

use App\Entity\Motive;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MotiveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Motive::class;
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
