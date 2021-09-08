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
use JMS\Serializer\SerializerInterface;

class ArticleController extends ApiController
{   
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
    * @Route("/createArticle",name="createArticle" , methods="POST")
    */
    
    public function createArticle( Request $request )
{
        $file =  new Article();
        $uploadedImage = $request->files->get('file');
        /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
        $imageName = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move($this->getParameter('image_directory'), $imageName);
        $file->setImage($imageName);

        $file->setTitle($request->get("title"));
        $file->setDescription($request->get("description"));
        $file->setDateAjout($request->get("DateAjout"));

        $em = $this->getDoctrine()->getManager();
        $em->persist($file);
        $em->flush();
        $response = array(

            'code' => 0,
            'message' => 'File Uploaded with success!',
            'errors' => null,
            'result' => null

        );
        return new JsonResponse($response, Response::HTTP_CREATED);
    }


    /**
    * @Route("/UpdateArticle/{id}", name="UpdateArticle", methods="PUT")
    */
    public function UpdateArticle($id , Request $request ) 
    {
    
        $file = $this->repository->findOneBy(['id' => $id]);
        if (! $file) {
            return new JsonResponse(['status' => 'offre not Found ']);
        }
        $file= new Article();

        
        $uploadedImage = $request->files->get('file');
        /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
        $imageName = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move($this->getParameter('image_directory'), $imageName);
        $file->setImage($imageName);



        $file->setTitle($request->get('title'));
        $file->setDescription($request->get('description'));
        $file->setDateAjout($request->get('DateAjout')); 
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($file);
        $em->flush();

       $response = array(

        'code' => 0,
        'message' => 'update with success!',
        'errors' => null, 
        'result' => null

    );
    return new JsonResponse($response, Response::HTTP_CREATED);
      
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
    
  
     /**
     * 
     * @Route("image", name="Articles"  ,methods={"GET"} )
     */



    public function getImages()
    {

        $images=$this->getDoctrine()->getRepository('App:Article')->findAll();


        $data=$this->get('serializer')->serialize($images,'json');

        $response=array(

            'message'=>'images loaded with sucesss',
            'result' => json_decode($data)

        );

        return new JsonResponse($response,200);

    }



}
