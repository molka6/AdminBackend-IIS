<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Avis;
use App\Repository\AvisRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{ 
    public function __construct(ManagerRegistry $registry, EntityManagerInterface  $em)
    {

        $this->em =  $em;
        parent::__construct($registry, Article::class  );
       


    }

    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function transformAll()
    {
        $Articles= $this->findAll();
        $ArticleArray = [];
        foreach ($Articles as $Article) {
            $ArticleArray[] = $this->transform($Article);
        }
        return $ArticleArray;
    
    }

    
    public function transform(Article  $article)
    {
        return [
                'id'    => (int) $article->getId(),
                'title' => (string) $article->getTitle(),
                'description' => (string) $article->getDescription(),
                'DateAjout' => (string)$article->getDateAjout(),
                'image'=>(string) $article->getImage(),

                           
        ];
    }

    public function updateArticle(Article $Article)
    {
        $this->em->persist($Article);
        $this->em->flush();

        return $Article;
    }


    public function removeArticle(Article $Article)
    {
        $this->em->remove($Article);
        $this->em->flush();
    }

  
   
}
