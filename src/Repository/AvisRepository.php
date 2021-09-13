<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Avis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avis[]    findAll()
 * @method Avis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry ,EntityManagerInterface  $em )
    {
        $this->em =  $em;
        parent::__construct($registry, Avis::class);
    }

    // /**
    //  * @return Avis[] Returns an array of Avis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Avis
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */




    public function findAvisOfArticle(int $articleId): ?array
    {
       
        return $this->createQueryBuilder('a')
        ->andWhere('a.article= :val AND a.publier = true ')
        ->setParameter('val', $articleId )
        ->getQuery()
        ->getResult();
       
      

    }

    
    public function findAvisOfArticleTOUS(int $articleId): ?array
    {
       
        return $this->createQueryBuilder('a')
        ->andWhere('a.article= :val')
        ->setParameter('val', $articleId )
        ->getQuery()
        ->getResult();
       
      

    }

    public function transform(Avis $avis)
    {
        return [
                'id'    => (int) $avis->getId(),
                'nom' => (string) $avis-> getNom(),
                'prenom' => (string) $avis->getPrenom(),
                'contenu'=> (string) $avis-> getContenu(),
                'date'=> (string) $avis->getDate(),
                'publier'=> (string) $avis->getPublier(),
                
        ];
    }

    public function removeCommentaire(  Avis $avis)
    {
        $this->em->remove($avis);
        $this->em->flush();
    }

    
}
