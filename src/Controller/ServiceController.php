<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use  App\Repository\ServiceRepository ; 
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Service ; 
class ServiceController extends ApiController
 {
//     #[Route('/service', name: 'service')]
//     public function index(): Response
//     {
//         return $this->render('service/index.html.twig', [
//             'controller_name' => 'ServiceController',
//         ]);
//     }


    /**
     * 
     * @Route("IlefService", name="IlefService"  ,methods={"GET"} )
     */
    public function index(ServiceRepository $repository)
    {
    
        $service = $repository->transformAll();
        return $this->respond($service);

    
    }


        
    /**
    * @Route("/createService",name="createService" , methods={"POST"})
    */
    
    public function createService( Request $request ,ServiceRepository $serviceRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }
        // validate the title
        if (! $request->get("title")) {
            return $this->respondValidationError('Please provide a titre !');
        }
        if (! $request->get("description")) {
            return $this->respondValidationError('Please provide a description !');
        }

        
        $service = new Service();
        $service-> setTitle($request->get('title'));
        $service-> setDescription($request->get('description'));
        $em->persist($service);
        $em->flush();
        return $this->respondCreated($serviceRepository->transform($service));
      
      
    }

}
