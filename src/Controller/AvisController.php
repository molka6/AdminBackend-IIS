<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AvisRepository; 
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Avis;

class AvisController extends ApiController
{
    #[Route('/avis', name: 'avis')]
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    public function __construct(AvisRepository $repository  )
    {
        $this-> repository= $repository;
    

         
    
    }

    
    /**
     * @Route("Avis/{id}", name="avis"  ,methods={"GET"})
     */
    public function show(int $id ,AvisRepository $repository ): Response
    {
        $avis = $this->getDoctrine()
            ->getRepository(Avis::class)
            ->findAvisOfArticle($id);
            foreach ($avis as $av) {
                $avisArray[] = $repository->transform($av);
                    }
        return $this->respond($avisArray);
       
    }




         /**
     * @Route("/Commentaire/{id}", name="deleteCommentaire", methods={"DELETE"})
     */
    public function deleteOffre($id): JsonResponse
    {
        $avis = $this->repository->findOneBy(['id' => $id]);
         $this->repository->removeCommentaire( $avis);

         return new JsonResponse(['status' => 'avis deleted']);
    }
 
}
