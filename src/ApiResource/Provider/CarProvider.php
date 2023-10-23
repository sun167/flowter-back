<?php
// src/AppBundle/DataProvider/BlogPostCollectionDataProvider.php
namespace App\DataProvider;
use App\Entity\Car;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

final class CarProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        if (BlogPost::class !== $resourceClass) {
            throw new ResourceClassNotSupportedException();
        }
        // Retrieve the blog post collection from somewhere
        return [new BlogPost(1), new BlogPost(2)];
    }
}