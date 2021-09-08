<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PartenaireRepository; 
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Partenaire; 
use Symfony\Component\HttpFoundation\File;

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
        // $request = $this->transformJsonBody($request);
        // if (! $request) {
        //     return $this->respondValidationError('Please provide a valid request!');
        // }
        // // validate the title
        // if (! $request->get("nom")) {
        //     return $this->respondValidationError('Please provide a nom !');
        // }
        // if (! $request->get("logo")) {
        //     return $this->respondValidationError('Please provide a logo!');
        // }

        // echo($request ); 
        $Partenaire = new Partenaire();
        $uploadedImage = $request->files->get('logo');
         /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
       
         $imageName = md5(uniqid()) . '.' . $image->guessExtension();
         $image->move($this->getParameter('image_directory'), $imageName);
         $Partenaire-> setNom($request->get('nom'));
        $Partenaire->setLogo($imageName);
        $em->persist($Partenaire);
        $em->flush();
        $response = array(

            'code' => 0,
            'message' => 'logo Uploaded with success!',
            'errors' => null,
            'result' => null

        );
        return new JsonResponse($response, Response::HTTP_CREATED);
      
      
    }

    /**
    * @Route("/UpdatePartenaire/{id}", name="UpdatePartenaire", methods="POST")
    */
    public function UpdatePartenaire($id , Request $request  ,EntityManagerInterface $em) : JsonResponse
    {
        $request->setMethod('PUT');
        $Partenaire = $this->repository->findOneBy(['id' => $id]);
        $uploadedImage = $request->files->get('logo');
         /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
       
         $imageName = md5(uniqid()) . '.' . $image->guessExtension();
         $image->move($this->getParameter('image_directory'), $imageName);
         $Partenaire-> setNom($request->get('nom'));
        $Partenaire->setLogo($imageName);
        $em->persist($Partenaire);
        $em->flush();
        $response = array(

            'code' => 0,
            'message' => 'Partner Updated!',
            'errors' => null,
            'result' => null

        );
        return new JsonResponse($response, Response::HTTP_CREATED);

  
    }






    /**
     * @Route("/getPartenaire/{id}", name="getPartenaire", methods="GET")
     */
    public function getPartenaire($id): JsonResponse
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





    /**
     * @Route("/logos", name="logos")
     */
    public function getImages()
    {
        $logos = $this->getDoctrine()->getRepository('App:Partenaire')->findAll();
        $data = $this->get('serializer')->serialize($logos, 'json');
        $response=array(

            'message'=>'images loaded with sucesss',
            'result' => json_decode($data)

        );
        return new JsonResponse($response, 200);
    }



    /**
     * @Route("image/{id}",name="show_image" ,methods={"GET"})
     */
    public function getImage($id)
    {
        $imageName=$this->getDoctrine()->getRepository('App:Partenaire')->find($id)->getLogo();
        $response=array(

            'code'=>0,
            'message'=>'get image with success!',
            'errors'=>null,
            'image'=>$imageName

        );
        return new JsonResponse($response,200);
    }




    /**
     * @Route("/PartenaireLogo/{id}", name="deletePartenaireLogo", methods={"Get"})
     */
    public function deletelogo($id): JsonResponse
    {
        $logo = $this->getDoctrine()
        ->getRepository(Partenaire::class)
        ->deleteOneLoGO($id);
        return new JsonResponse(['status' => 'logo deleted']);
    }



}
