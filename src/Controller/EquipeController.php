<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Equipe;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File;
use App\Repository\EquipeRepository;

class EquipeController extends ApiController
{

    public function __construct(EquipeRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("/personne", name="personne")
     */
    public function index()
    {
        $personns = $this->repository->transformAll();
        return $this->respond($personns);
    }





    /** 
     * @Route("/createpersonne", name="createpersonne" , methods={"POST"}  )
     */
    public function createEquipe(Request $request)
    {
        $file =  new Equipe();
        $uploadedImage = $request->files->get('file');
        /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
        $imageName = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move($this->getParameter('image_directory'), $imageName);
        $file->setImage($imageName);
        $file->setNom($request->get('nom'));
        $file->setPrenom($request->get("prenom"));
        $file->setRole($request->get("role"));
        $file->setEmail($request->get("Email"));
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
     * @Route("/updatepersonn/{id}")
     */
    public function Updatepersonne($id, Request $request, EquipeRepository $repository): JsonResponse
    {
        $offreEmploi = $repository->findOneBy(['id' => $id]);
        if (!$offreEmploi) {
            return new JsonResponse(['status' => 'personne not Found ']);
        }
        $request = $this->transformJsonBody($request);

        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (!$request->get("nom")) {
            return $this->respondValidationError('Please provide a nom!');
        }
        if (!$request->get("prenom")) {
            return $this->respondValidationError('Please provide a prenom !');
        }
        if (!$request->get("role")) {
            return $this->respondValidationError('Please provide a role!');
        }
        if (!$request->get("Email")) {
            return $this->respondValidationError('Please provide Email!');
        }
        $offreEmploi->setNom($request->get("nom"));
        $offreEmploi->setPrenom($request->get("prenom"));
        $offreEmploi->setRole($request->get("role"));
        $offreEmploi->setEmail($request->get("Email"));
        $updatedOffre = $repository->updateOffre($offreEmploi);
        return new JsonResponse($updatedOffre->toArray(), Response::HTTP_OK);
    }
    /**
     * @Route("personne/{id}", name="getpersonn", methods="GET")
     */
    public function getOffre($id, EquipeRepository $repository): JsonResponse
    {
        $offreEmploi = $repository->findOneBy(['id' => $id]);
        return new JsonResponse($offreEmploi->toArray(), Response::HTTP_OK);
    }


    /**
     * @Route("/delete/{id}", methods="DELETE")
     */
    public function deletepersonne($id, EquipeRepository $repository): JsonResponse
    {
        $offreEmploi = $repository->findOneBy(['id' => $id]);
        $repository->removeoffre($offreEmploi);
        return new JsonResponse(['status' => ' deleted']);
    }

     /**
     * @Route("/images", name="images")
     */


    public function getImages()
    {


        $images=$this->getDoctrine()->getRepository('App:File')->findAll();


        $data=$this->get('jms_serializer')->serialize($images,'json');

        $response=array(

            'message'=>'images loaded with sucesss',
            'result' => json_decode($data)

        );

        return new JsonResponse($response,200);

    }


}
