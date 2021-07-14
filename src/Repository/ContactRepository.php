<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    
    public function transform(Contact $Contact)
    {
        return [
                'id'    => (int) $Contact->getId(),
                'nom' => (string) $Contact-> getNom(),
                'prenom' => (string) $Contact->getPrenom(),
                'mail' => (string) $Contact->getMail(),
                'message' => (string) $Contact->getMessage(),   
                'date' => (string) $Contact->getDate(),  
        ];
    }
    public function transformAll()
    {
        $Contacts = $this->findAll();
        $ContactArray = [];
        foreach ($Contacts as $Contact) {
            $ContactArray[] = $this->transform($Contact);
        }
        return $ContactArray;
    }

}
