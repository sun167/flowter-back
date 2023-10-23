<?php

namespace App\ApiResource\Extension;
use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

class CarRideExtension implements QueryCollectionExtensionInterface
{
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (Car::class !== $resourceClass) {
            return;
        }
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.isPublished = :isPublished', $rootAlias))
            ->setParameter('isPublished', true);
            $queryBuilder->leftJoin("$rootAlias.ride", 'ride');
            $rootAlias = 'ride';
            $queryBuilder->leftJoin("$rootAlias.ride", 'ride');
            $queryBuilder->leftJoin('ride.company', 'company');
            $rootAlias = 'company';
        }
        
}
