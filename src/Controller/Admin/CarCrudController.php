<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('model.nbSeats', 'Number of Seats')->hideOnForm(),
            AssociationField::new('options')->hideOnIndex(),
            AssociationField::new('company'),
            AssociationField::new('model'),
            TextField::new('licensePlate'),
            DateTimeField::new('insuranceDate')
        ];
    }
    
}
