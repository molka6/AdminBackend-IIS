<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
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




    
public function __construct(ArticleRepository $repository ,  EntityManagerInterface  $em )
{
    $this-> repository= $repository;
    $this->em =  $em;

     

}
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
    * @Route("/createArticle",name="createArticle" , methods={"POST"})
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

       $updatedArticle= $this->repository->updateArticle($Article);
       return new JsonResponse($updatedArticle->toArray(), Response::HTTP_OK);

      
    }

     /**
    * @Route("/getArticle/{id}", name="getArticle", methods="GET")
    */

    public function getArticle ($id): JsonResponse

        {
             
        $Article= $this->repository->findOneBy(['id' => $id]);
        return new JsonResponse($Article->toArray(), Response::HTTP_OK);

        }

    /**
     * @Route("/Article/{id}", name="deleteArticle", methods={"DELETE"})
     */
    public function deleteArticle($id): JsonResponse
    {
        $Article = $this->repository->findOneBy(['id' => $id]);
         $this->repository->removeArticle($Article);

         return new JsonResponse(['status' => 'Article deleted']);
    }
    


}
