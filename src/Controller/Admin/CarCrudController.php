<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
            NumberField::new('nbSeats', 'Number of Seats'),
            AssociationField::new('options')->setFormTypeOption('label', 'options')->hideOnIndex(),
            AssociationField::new('company')->setPermission("ROLE_ADMIN"),
            NumberField::new('horsePower'),
            ChoiceField::new('gearbox')
                ->setChoices([
                'Manuel' => 0,
                'Automatic' => 1
                ]),
            ChoiceField::new('fuel')
                ->setChoices([
                'Diesel' => 0,
                'Essence' => 1,
                'Electrique' =>2
                ]),            
            TextField::new('licensePlate'),
            DateTimeField::new('insuranceDate')
        ];
    }
    
}
