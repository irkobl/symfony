<?php

namespace App\Repository;

use App\Entity\ApplicationFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplicationFile>
 *
 * @method ApplicationFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationFile[]    findAll()
 * @method ApplicationFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationFile::class);
    }

    public function save(ApplicationFile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplicationFile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function allFiles ()
    {          
        $db = $this->getEntityManager()->getConnection();
        $sql = 'select * from application_file app_file';

        $res = $db->prepare($sql)->executeQuery()->fetchAllAssociativeIndexed();
        return $res;
    }

    public function removeArray (array $arr, bool $flush = false): void
    {
        foreach ($arr as $file) {            
            $this->getEntityManager()->remove($file);
            if ($flush) {
                $this->getEntityManager()->flush();
            }                 
        }
    }
    
    
//    /**
//     * @return ApplicationFile[] Returns an array of ApplicationFile objects
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

//    public function findOneBySomeField($value): ?ApplicationFile
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
