<?php

namespace App\Repository;

use App\Entity\OffreEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @method OffreEmploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreEmploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreEmploi[]    findAll()
 * @method OffreEmploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface  $em)
    {

        $this->em =  $em;
        parent::__construct($registry, OffreEmploi::class  );
       


    }


    // /**
    //  * @return OffreEmploi[] Returns an array of OffreEmploi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreEmploi
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function transformAll()
    {
        $offres = $this->findAll();
        $offreArray = [];
        foreach ($offres as $offre) {
            $offreArray[] = $this->transform($offre);
        }
        return $offreArray;
    
    }

    
    public function transform(OffreEmploi $offre)
    {
        return [
                'id'    => (int) $offre->getId(),
                'title' => (string) $offre->getTitre(),
                'description' => (string) $offre->getDescription(),
                'DateAjout' => (string) $offre->getDateAjout(),               
        ];
    }

    public function updateOffre(OffreEmploi $offre)
    {
        $this->em->persist($offre);
        $this->em->flush();

        return $offre;
    }


    public function removeoffre(OffreEmploi $offre)
    {
        $this->em->remove($offre);
        $this->em->flush();
    }
    

    public function myFindByTypes($offre)
    {
        $qb = $this->createQueryBuilder('card')
           ->leftJoin ('card.condidature','t')
           ->where('t.id= :id')
           ->setParameter('id', $offre);
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results;
    }

}
