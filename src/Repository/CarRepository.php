<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Ride;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByTimeFrame($startDate, $endDate): array
//    {
//     return $this->createQueryBuilder("c")
//         ->leftJoin("c.rides", "ride")
//         // ->andWhere("ride.id == NULL OR ride.dateOfReturn < :startDate OR ride.dateOfLoan < :endDate")
//         ->andWhere("ride.id == NULL") 
//         // ->orWhere("ride.dateOfReturn < :startDate") 
//         // ->orWhere("ride.dateOfLoan < :endDate")
//         // ->setParameter("startDate", $startDate)
//         // ->setParameter("endDate", $endDate)
//         ->getQuery()
//         ->getResult();
//    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByTimeFrame($startDate, $endDate): array
//    {
//     $em = $this->getDoctrine()->getManager();
//     $qb = $this->createQueryBuilder("c");   
//     $rides = $em->getRepository(Ride::class);
//     $sub = $rides->createQueryBuilder("")->select("r1")->from("Ride","r1");        
//     $sub->andWhere($sub->expr()
//                     ->orX(
//                         $sub->expr()->andX(
//                             $sub->expr()->lte("r1.dateOfLoan",":endDate"),
//                             $sub->expr()->gte("r1.dateOfReturn",":endDate")),
//                         $sub->expr()->andX(
//                             $sub->expr()->lte("r1.dateOfLoan",":startDate"),
//                             $sub->expr()->gte("r1.dateOfReturn",":startDate")),
//                         $sub->expr()->andX(
//                             $sub->expr()->lte("r1.dateOfLoan",":startDate"),
//                             $sub->expr()->gte("r1.dateOfReturn",":endDate")),
//                     ));
//     $sub->setParameter("startDate", $startDate)->setParameter("endDate", $endDate);
//     return $qb
//         ->andWhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())))
//         ->getQuery()
//         ->getResult();
//    }
public function createQueryFindByTimeFrame($startDate, $endDate, QueryBuilder $qb)
{
    $sub = $this->_em->createQueryBuilder();
    $sub->select('r2.id')
        ->from('App\Entity\Ride', 'r2')
        ->where(
            $sub->expr()->orX(
                $sub->expr()->andX(
                    $sub->expr()->lte('r2.dateOfLoan', ':endDate'),
                    $sub->expr()->gte('r2.dateOfReturn', ':endDate')
                ),
                $sub->expr()->andX(
                    $sub->expr()->lte('r2.dateOfLoan', ':startDate'),
                    $sub->expr()->gte('r2.dateOfReturn', ':startDate')
                ),
                $sub->expr()->andX(
                    $sub->expr()->gte('r2.dateOfLoan', ':startDate'),
                    $sub->expr()->lte('r2.dateOfReturn', ':endDate')
                )
            )
        );

    $qb->select('c')
        ->from('App\Entity\Car', 'c')
        ->leftJoin('c.rides', 'ride')
        ->andWhere(
            $qb->expr()->orX(
                $qb->expr()->isNull('ride.id'),
                $qb->expr()->not($qb->expr()->exists($sub->getDQL()))
            )
        )
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate);
}
public function findByTimeFrame($startDate, $endDate): array
{
    $qb = $this->_em->createQueryBuilder();

    $sub = $this->_em->createQueryBuilder();
    $sub->select('r2.id')
        ->from('App\Entity\Ride', 'r2')
        ->where(
            $sub->expr()->orX(
                $sub->expr()->andX(
                    $sub->expr()->lte('r2.dateOfLoan', ':endDate'),
                    $sub->expr()->gte('r2.dateOfReturn', ':endDate')
                ),
                $sub->expr()->andX(
                    $sub->expr()->lte('r2.dateOfLoan', ':startDate'),
                    $sub->expr()->gte('r2.dateOfReturn', ':startDate')
                ),
                $sub->expr()->andX(
                    $sub->expr()->gte('r2.dateOfLoan', ':startDate'),
                    $sub->expr()->lte('r2.dateOfReturn', ':endDate')
                )
            )
        );

    $qb->select('c')
        ->from('App\Entity\Car', 'c')
        ->leftJoin('c.rides', 'ride')
        ->andWhere(
            $qb->expr()->orX(
                $qb->expr()->isNull('ride.id'),
                $qb->expr()->not($qb->expr()->exists($sub->getDQL()))
            )
        )
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate);

    return $qb->getQuery()->getResult();
}
//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder("c")
//            ->andWhere("c.exampleField = :val")
//            ->setParameter("val", $value)
//            ->orderBy("c.id", "ASC")
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder("c")
//            ->andWhere("c.exampleField = :val")
//            ->setParameter("val", $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
