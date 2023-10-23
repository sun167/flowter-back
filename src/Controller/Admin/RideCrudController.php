<?php

namespace App\Controller\Admin;

use App\Entity\Ride;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class RideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ride::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('dateOfLoan'),
            DateTimeField::new('dateOfReturn'),
            AssociationField::new('users')->hideOnIndex(),
            AssociationField::new('driver'),
            AssociationField::new('motive'),
            NumberField::new('mileageBefore'),
            NumberField::new('mileageAfter'),
        ];
    }
   
}
