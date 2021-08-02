<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use  App\Repository\ServiceRepository ; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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




public function __construct(ServiceRepository $repository ,  EntityManagerInterface  $em )
{
    $this-> repository= $repository;
    $this->em =  $em;

     

}

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
        $service-> setPourcentage($request->get('pourcentage'));
        $em->persist($service);
        $em->flush();
        return $this->respondCreated($serviceRepository->transform($service));
      
      
    }

    /**
    * @Route("/UpdateService/{id}", name="UpdateService", methods="PUT")
    */
    public function UpdateService($id , Request $request ) : JsonResponse
    {
        $request = $this->transformJsonBody($request);
       
        $Service = $this->repository->findOneBy(['id' => $id]);
        if (! $Service) {
            return new JsonResponse(['status' => 'offre not Found ']);
        }

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get("title")) {
            return $this->respondValidationError('Please provide a title!');
        }
        if (! $request->get("description")) {
            return $this->respondValidationError('Please provide a description !');
        }
      
    
        $Service->setTitle($request->get("title"));
        $Service->setDescription($request->get("description"));
      
       $updatedService= $this->repository->updateService( $Service);
       return new JsonResponse($updatedService->toArray(), Response::HTTP_OK);

      
    }

    /**
    * @Route("/getService/{id}", name="getService", methods="GET")
    */

    public function getService ($id): JsonResponse

        {
             
        $service = $this->repository->findOneBy(['id' => $id]);
        return new JsonResponse( $service ->toArray(), Response::HTTP_OK);

        }


    /**
     * @Route("/Service/{id}", name="deleteService", methods={"DELETE"})
     */
    public function deleteService($id): JsonResponse
    {
        $Service = $this->repository->findOneBy(['id' => $id]);
         $this->repository->removeService($Service);

         return new JsonResponse(['status' => 'Service deleted']);
    }
    

}
