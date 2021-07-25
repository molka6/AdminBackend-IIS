<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Equipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipe[]    findAll()
 * @method Equipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry , EntityManagerInterface  $em)
    {
        $this->em =  $em;
        parent::__construct($registry, Equipe::class);
    }

    // /**
    //  * @return Equipe[] Returns an array of Equipe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Equipe
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function transform(Equipe $article)
    {
        return [
                'id'    => (int) $article->getId(),
                'nom' => (string) $article-> getNom(),
                'prenom' => (string) $article->getPrenom(),
                'role' => (string) $article->getRole(),
                'Email' => (string) $article->getEmail(),   
                'Image' => (string) $article->getImage(),  
        ];
    }
    public function transformAll()
    {
        $articles = $this->findAll();
        $articleArray = [];
        foreach ($articles as $article) {
            $articleArray[] = $this->transform($article);
        }
        return $articleArray;
    }

    public function updateOffre(Equipe $offre)
    {
        $this->em->persist($offre);
        $this->em->flush();
        return $offre;
    }


    public function removeoffre(Equipe $offre)
    {
        $this->em->remove($offre);
        $this->em->flush();
    }



}
