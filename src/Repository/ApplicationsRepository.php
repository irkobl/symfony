<?php

namespace App\Repository;


use App\Entity\Applications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Applications>
 *
 * @method Applications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Applications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Applications[]    findAll()
 * @method Applications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Applications::class);
    }

    public function save(Applications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Applications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function allApplication (): array
    {          
        $db = $this->getEntityManager()->getConnection();
        $sql = 'select app.* from applications app';

        $res = $db->prepare($sql)->executeQuery()->fetchAllAssociative();
        return $res;
    }

    public function timeApp (): array
    {
    
       return $this->createQueryBuilder('a')
           ->select('a.id, a.created_at')
           ->where("a.status like '%Новое%'")                      
           ->orderBy('a.id', 'ASC')           
           ->getQuery()
           ->getArrayResult();                
       ;
    }

    public function getCompletedApplication (): QueryBuilder
    {
        return $this->createQueryBuilder('a')            
            ->andWhere("a.status like 'Завершена'")
            ->andWhere('a.created_at < :date')
            ->setParameters([                
                'date' => new \DateTimeImmutable('-3 days'),
            ])            
        ;
    }

    public function getIdCompletedApplication (): array
    {
        return $this->getCompletedApplication()
        ->select('a.id')
        ->getQuery()
        ->getArrayResult();
    }

    public function removeCompletedApplication ()
    {
        return $this->getCompletedApplication()->delete()->getQuery()->execute();
    }




//    /**
//     * @return Applications[] Returns an array of Applications objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Applications
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
