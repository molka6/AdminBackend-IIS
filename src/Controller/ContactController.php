<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository ; 

class ContactController extends ApiController
{
    // #[Route('/contact', name: 'contact')]
    // public function index(): Response
    // {
    //     return $this->render('contact/index.html.twig', [
    //         'controller_name' => 'ContactController',
    //     ]);
    // }

    /**
     * 
     * @Route("Contacts", name="Contacts"  ,methods={"GET"} )
     */
    public function index(ContactRepository $repository)
    {
    
        $Contact = $repository->transformAll();
        return $this->respond($Contact);

    
    }
     /**
    * @Route("Contact/{id}", name="Contact", methods="GET")
    */
    public function getOneContact ($id , ContactRepository $repository ): JsonResponse
        {   
        $Contact =$repository->findOneBy(['id' => $id]);
        return new JsonResponse($Contact->toArray(), Response::HTTP_OK);
        }

    
}
