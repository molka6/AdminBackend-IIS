<?php

namespace App\Repository;

use App\Entity\Partenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @method Partenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaire[]    findAll()
 * @method Partenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaireRepository extends ServiceEntityRepository
{
   


    public function __construct(ManagerRegistry $registry, EntityManagerInterface  $em)
    {

        $this->em =  $em;
        parent::__construct($registry, Partenaire::class  );
       


    }
    // /**
    //  * @return Partenaire[] Returns an array of Partenaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partenaire
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function transformAll()
    {
        $partenaires= $this->findAll();
        $partenaireArray = [];
        foreach ($partenaires as $partenaire) {
            $partenaireArray[] = $this->transform($partenaire);
        }
        return $partenaireArray;
    
    }

    
 
       
    public function transform(Partenaire  $partenaire)
    {
        return [
                'id'    => (int) $partenaire->getId(),
                'nom' => (string) $partenaire->getNom(),
                'logo' => (string) $partenaire-> getLogo(),
                            
        ];
    }

   

    public function updatePartenaire(Partenaire  $partenaire)
    {
        $this->em->persist($partenaire);
        $this->em->flush();

        return $partenaire;
    }

    public function removePartenaire(Partenaire  $partenaire)
    {
        $this->em->remove($partenaire);
        $this->em->flush();
    }


    public function deleteOneLoGO(int $PartenaireId): ?int
    {
       
        return $this->em->createQueryBuilder()
        ->update(Partenaire::class, 'p')
        ->set('p.logo', ':Null')
        ->where('p.id= :val')
        ->setParameter('val', $PartenaireId)
        ->setParameter('Null', '')
        ->getQuery()
        ->getResult();
        
       
      

    }
}
