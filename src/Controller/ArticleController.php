<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OffreEmploiRepository;
use App\Repository\ArticleRepository ; 
use App\Entity\Article; 

class ArticleController extends ApiController
{
    // #[Route('/article', name: 'article')]
    // public function index(): Response
    // {
    //     return $this->render('article/index.html.twig', [
    //         'controller_name' => 'ArticleController',
    //     ]);
    // }


    /**
     * 
     * @Route("Articles", name="Articles"  ,methods={"GET"} )
     */
    public function index(ArticleRepository $repository)
    {
    
        $Articles = $repository->transformAll();
        return $this->respond($Articles);

    
    }

     /**
    * @Route("/createArticle",name="createArticle" , methods="POST")
    */
    
    public function createArticle( Request $request , ArticleRepository $ArticleRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
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
        if (! $request->get("DateAjout")) {
            return $this->respondValidationError('Please provide a description!');
        }
        if (! $request->get("image")) {
            return $this->respondValidationError('Please provide a description!');
        }

        
        $Article = new Article();
        $Article-> setTitle($request->get('title'));
        $Article->setDescription($request->get('description'));
        $Article->setDateAjout($request->get('DateAjout')); 
        $Article->setImage($request->get('image')); 

        $em->persist( $Article);
        $em->flush();
        return $this->respondCreated($ArticleRepository->transform($Article));
      
      
    }


    /**
    * @Route("/UpdateArticle/{id}", name="UpdateArticle", methods="PUT")
    */
    public function UpdateArticle($id , Request $request ) : JsonResponse
    {
        $request = $this->transformJsonBody($request);
       
        $Article = $this->repository->findOneBy(['id' => $id]);
        if (! $Article) {
            return new JsonResponse(['status' => 'offre not Found ']);
        }

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }
        if (! $request->get("title")) {
            return $this->respondValidationError('Please provide a title!');
        }
        if (! $request->get("description")) {
            return $this->respondValidationError('Please provide a description !');
        }
        if (! $request->get("DateAjout")) {
            return $this->respondValidationError('Please provide a description!');
        }
        if (! $request->get("image")) {
            return $this->respondValidationError('Please provide a description!');
        }
    
        $Article = new Article();
        $Article-> setTitle($request->get('title'));
        $Article->setDescription($request->get('description'));
        $Article->setDateAjout($request->get('DateAjout')); 
        $Article->setImage($request->get('image'));  

       $updatedArticle= $this->repository->updateArticle( $offreArticle);
       return new JsonResponse($updatedArticle->toArray(), Response::HTTP_OK);

      
    }


}
