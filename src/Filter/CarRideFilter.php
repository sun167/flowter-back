<?php
// src/Filter/CarDateAndLocationFilter.php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractDateFilter;
use ApiPlatform\Doctrine\Orm\Filter\AbstractSearchFilter;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;

class CarRideFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        if (
            null === $value
            || !$this->isPropertyEnabled($property, $resourceClass)
            || !$this->isPropertyMapped($property, $resourceClass, true)
        ) {
            return;
        }

        // Check if the filter property is supported (e.g., "date_of_loan", "date_of_return", "departureSite").
        if (!in_array($property, ['date_of_loan', 'date_of_return', 'departureSite'])) {
            return;
        }

        // Apply the filter to the query builder based on the filter property.
        $parameterName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder->leftJoin("car.ride", 'ride');
        $queryBuilder->leftJoin('ride.company', 'company');
        $rootAlias = 'company';
         // Join the necessary associations if they haven't been joined already.
        $rootAlias = $queryBuilder->getRootAliases()[0];
        if ($property === 'date_of_loan' || $property === 'date_of_return') {
            $queryBuilder->leftJoin("$rootAlias.ride", 'ride');
            $rootAlias = 'ride';
        } elseif ($property === 'departureSite') {
            $queryBuilder->leftJoin("$rootAlias.ride", 'ride');
            $queryBuilder->leftJoin('ride.company', 'company');
            $rootAlias = 'company';
        }
            
        if ($property === 'date_of_loan') {
            $queryBuilder->andWhere("$rootAlias.dateOfLoan < :$parameterName");
        } elseif ($property === 'date_of_return') {
            $queryBuilder->andWhere("$rootAlias.dateOfReturn < :$parameterName");
            $queryBuilder->andWhere("$rootAlias.dateOfReturn < :$parameterName");
        } elseif ($property === 'departureSite') {
            $queryBuilder->andWhere("$rootAlias.name = :$parameterName");
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'departureDate' => [
                'property' => 'departureDate',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter cars with date_of_loan < departure Date or date of loan > return Date',
                ],
            ],
            'returnDate' => [
                'property' => 'returnDate',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter cars with date_of_return > returnDate or date of return < departure Date',
                ],
            ],
            'departureSite' => [
                'property' => 'departureSite',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter cars with location.location_adresse = departureSite',
                ],
            ],
        ];
    }
}
