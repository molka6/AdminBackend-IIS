<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OffreEmploiRepository;
use App\Entity\OffreEmploi;

class OffreEmploiController extends ApiController
{
    // #[Route('/offre/emploi', name: 'offre_emploi')]
    // public function index(): Response
    // {
    //     return $this->render('offre_emploi/index.html.twig', [
    //         'controller_name' => 'OffreEmploiController',
    //     ]);
    // }

    


    public function __construct(OffreEmploiRepository $repository ,  EntityManagerInterface  $em )
    {
        $this-> repository= $repository;
        $this->em =  $em;

         
    
    }
    


    /**
     * 
     * @Route("offreEmploi", name="offreEmploi"  ,methods={"GET"} )
     */
    public function index(OffreEmploiRepository $repository)
    {
    
        $offres = $repository->transformAll();
        return $this->respond($offres);

    
    }


    
    /**
    * @Route("/createoffreEmploi",name="createoffreEmploi" , methods={"POST"})
    */
    
    public function createOffre( Request $request , OffreEmploiRepository $offreEmploiRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }
        // validate the title
        if (! $request->get("titre")) {
            return $this->respondValidationError('Please provide a title!');
        }
        if (! $request->get("description")) {
            return $this->respondValidationError('Please provide a description !');
        }
        if (! $request->get("date_ajout")) {
            return $this->respondValidationError('Please provide a description!');
        }

        
        $offreEmploi = new OffreEmploi();
        $offreEmploi->setTitre($request->get('titre'));
        $offreEmploi->setDescription($request->get('description'));
        $offreEmploi->setDateAjout($request->get('date_ajout')); 
        $em->persist($offreEmploi);
        $em->flush();
        return $this->respondCreated($offreEmploiRepository->transform($offreEmploi));
      
      
    }
/**
    * @Route("/UpdateoffreEmploi/{id}", name="UpdateoffreEmploi", methods="PUT")
    */
    public function UpdateOffre($id , Request $request ) : JsonResponse
    {
        $request = $this->transformJsonBody($request);
       
        $offreEmploi = $this->repository->findOneBy(['id' => $id]);
        if (! $offreEmploi) {
            return new JsonResponse(['status' => 'offre not Found ']);
        }

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get("titre")) {
            return $this->respondValidationError('Please provide a title!');
        }
        if (! $request->get("description")) {
            return $this->respondValidationError('Please provide a description !');
        }
        if (! $request->get("date_ajout")) {
            return $this->respondValidationError('Please provide a description!');
        }
    
       $offreEmploi->setTitre($request->get("titre"));
       $offreEmploi->setDescription($request->get("description"));
       $offreEmploi->setDateAjout($request->get("date_ajout"));
       $updatedOffre= $this->repository->updateOffre( $offreEmploi);
       return new JsonResponse($updatedOffre->toArray(), Response::HTTP_OK);

      
    }


    /**
    * @Route("/getOffre/{id}", name="getOffre", methods="GET")
    */

    public function getOffre ($id): JsonResponse

        {
             
        $offreEmploi = $this->repository->findOneBy(['id' => $id]);
        return new JsonResponse($offreEmploi->toArray(), Response::HTTP_OK);

        }


         /**
     * @Route("/offreEmploi/{id}", name="deleteOffre", methods={"DELETE"})
     */
    public function deleteOffre($id): JsonResponse
    {
        $offreEmploi = $this->repository->findOneBy(['id' => $id]);
         $this->repository->removeoffre($offreEmploi);

         return new JsonResponse(['status' => 'offre deleted']);
    }
    





}
