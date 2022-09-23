<?php

namespace App\Repository;

use App\Entity\Applications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function add(Applications $entity, bool $flush = false): void
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

//    /**
//     * @return Applications[] Returns an array of Applications objects
//     */
   public function timeApp (): array
   {
    
       return $this->createQueryBuilder('a')
           ->select('a.id, a.created_at')                      
           ->orderBy('a.id', 'ASC')           
           ->getQuery()
           ->getArrayResult();                
       ;
   }
}
