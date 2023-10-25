<?php 
namespace App\Filter;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Filter\Filter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterBuilder;
use Symfony\Component\Security\Core\Security;

class CompanyUserFilter extends Filter
{
    private $em;
    private $security;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function configure(FilterBuilder $filterBuilder): void
    {
        if ($this->security->isGranted('ROLE_GESTIONNAIRE')) {
            $user = $this->security->getUser();

            $filterBuilder
                ->setField('company') // Replace with your actual field name
                ->setFormTypeOptions(['choices' => $this->getCompanyUsers($user)])
                ->setMappingType('select');
        }
    }

    private function getCompanyUsers($user)
    {
        // Implement your logic to fetch users of the same company as $user
        // This will depend on how your entities are structured and the relationships between User and Company entities
        // Return an array of available choices
    }
}