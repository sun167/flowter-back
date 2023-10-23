<?php
// src/Filter/CarDateAndLocationFilter.php

namespace App\ApiResource\Filter;

use ApiPlatform\Api\FilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\AbstractDateFilter;
use ApiPlatform\Doctrine\Orm\Filter\AbstractSearchFilter;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\Query\Expr\Join;

class CarRideFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
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
        $alias = $queryBuilder->getRootAliases()[0];
        $field = $property;
        $queryBuilder->innerJoin("$alias.ride", 'ride');
        
        if ($this->isPropertyNested($property, $resourceClass)) {
            [$alias, $field] = $this->addJoinsForNestedProperty($property, $alias, $queryBuilder, $queryNameGenerator, $resourceClass, Join::INNER_JOIN);
        }
        echo "test";
        $valueParameter = $queryNameGenerator->generateParameterName($field);
         // Join the necessary associations if they haven't been joined already.

        if ($property === 'date_of_loan' || $property === 'date_of_return') {
            $queryBuilder->innerJoin("$alias.ride", 'ride');
            $rootAlias = 'ride';
        } elseif ($property === 'departureSite') {
            $queryBuilder->innerJoin("$alias.ride", 'ride');
            $queryBuilder->innerJoin('ride.company', 'company');
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
    $queryBuilder
        ->andWhere(sprintf("$alias.id = 2"));
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
