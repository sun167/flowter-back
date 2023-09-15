<?php

namespace App\Controller\Admin;

use App\Entity\Model;
use App\GearBox;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class ModelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Model::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label'),
            NumberField::new('nbSeats', 'Number of Seats'),
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
            AssociationField::new('brand'),
            AssociationField::new('carType'),
        ];
    }
    
}
