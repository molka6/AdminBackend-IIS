<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PartenaireRepository; 
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Partenaire; 

class PartenaireController extends ApiController 
{
    // #[Route('/partenaire', name: 'partenaire')]
    // public function index(): Response
    // {
    //     return $this->render('partenaire/index.html.twig', [
    //         'controller_name' => 'PartenaireController',
    //     ]);
    // }

    public function __construct(PartenaireRepository $repository ,  EntityManagerInterface  $em )
    {
        $this-> repository= $repository;
        $this->em =  $em;

         
    
    }
    
    /**
     * 
     * @Route("Partenaire", name="Partenaire"  ,methods={"GET"} )
     */
    public function index(PartenaireRepository $repository)
    {
    
        $Partenairs = $repository->transformAll();
        return $this->respond($Partenairs);

    
    }


      
    /**
    * @Route("/createPartenaire",name="createPartenaire" , methods={"POST"})
    */
    
    public function createPartenaire( Request $request ,PartenaireRepository $partenaireRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }
        // validate the title
        if (! $request->get("nom")) {
            return $this->respondValidationError('Please provide a nom !');
        }
        if (! $request->get("logo")) {
            return $this->respondValidationError('Please provide a logo!');
        }

        
        $Partenaire = new Partenaire();
        $Partenaire-> setNom($request->get('nom'));
        $Partenaire->setLogo($request->get('logo'));
        $em->persist($Partenaire);
        $em->flush();
        return $this->respondCreated($partenaireRepository->transform($Partenaire));
      
      
    }

    /**
    * @Route("/UpdatePartenaire/{id}", name="UpdatePartenaire", methods="PUT")
    */
    public function UpdatePartenaire($id , Request $request ) : JsonResponse
    {
        $request = $this->transformJsonBody($request);
       
        $partenaire = $this->repository->findOneBy(['id' => $id]);
        if (! $partenaire) {
            return new JsonResponse(['status' => 'offre not Found ']);
        }

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }
        // validate the title
        if (! $request->get("nom")) {
            return $this->respondValidationError('Please provide a nom !');
        }
        if (! $request->get("logo")) {
            return $this->respondValidationError('Please provide a logo!');
        }
        $partenaire-> setNom($request->get('nom'));
        $partenaire->setLogo($request->get('logo'));
       $updatedPartenaire= $this->repository->updatePartenaire(  $partenaire);
       return new JsonResponse($updatedPartenaire->toArray(), Response::HTTP_OK);

      
    }

    
    /**
    * @Route("/getPartenaire/{id}", name="getPartenaire", methods="GET")
    */

    public function getPartenaire ($id): JsonResponse

        {
             
        $Partenaire= $this->repository->findOneBy(['id' => $id]);
        return new JsonResponse($Partenaire->toArray(), Response::HTTP_OK);

        }


    /**
     * @Route("/Partenaire/{id}", name="deletePartenaire", methods={"DELETE"})
     */
    public function deletePartenaire($id): JsonResponse
    {
        $partenaire = $this->repository->findOneBy(['id' => $id]);
         $this->repository->removePartenaire($partenaire);

         return new JsonResponse(['status' => 'Partenaire deleted']);
    }

}
