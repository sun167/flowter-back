<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName', 'First Name'),
            TextField::new('lastName', 'Last Name'),
            TextField::new('email', 'Email address'),
            TextField::new('password', 'Password'),
            TextField::new('phone', 'Telephone number'),
            ArrayField::new('roles','Role of user')->setPermission("ROLE_ADMIN"),
            AssociationField::new('company', 'Company')->setPermission("ROLE_ADMIN"),
            BooleanField::new('driverLicenseCheck', 'Has a checked driver licence?'),
            BooleanField::new('identityCheck', 'Has a checked ID card?'),
            
            // TextField::new('title'),
            // TextEditorField::new('description'),
        ];
    }
    
}
