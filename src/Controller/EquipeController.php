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
use JMS\Serializer\SerializerInterface;

class EquipeController extends ApiController
{



    public function __construct(EquipeRepository $repository )
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
    public function Updatepersonne($id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $request->setMethod('PUT');
        $equipe = $this->repository->findOneBy(['id' => $id]);
        if (!$request->files->get('file') )
        {
            $equipe->setNom($request->get('nom'));
            $equipe->setPrenom($request->get('prenom'));
            $equipe->setRole($request->get('role'));
            $equipe->setEmail($request->get('Email'));
            $em->persist($equipe);
            $em->flush();
            $response = array(
                'code' => 0,
                'message' => 'Partner Updated!',
                'errors' => null,
                'result' => null
    
            );
            return new JsonResponse("hhhhh");

        }
        else 
        {
        $uploadedImage = $request->files->get('file');
        /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
        $imageName = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move($this->getParameter('image_directory'), $imageName);
        $equipe->setNom($request->get('nom'));
        $equipe->setPrenom($request->get('prenom'));
        $equipe->setRole($request->get('role'));
        $equipe->setEmail($request->get('Email'));
        $equipe->setImage($imageName);
        $em->persist($equipe);
        $em->flush();
        $response = array(
            'code' => 0,
            'message' => 'Partner Updated!',
            'errors' => null,
            'result' => null

        );
        return new JsonResponse($response, Response::HTTP_CREATED);
    }
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
        $images = $this->getDoctrine()->getRepository('App:Equipe')->findAll();
        $data = $this->get('serializer')->serialize($images, 'json');
        $response = array(
            'message' => 'images loaded with sucesss',
            'result' => json_decode($data)

        );
        return new JsonResponse($response, 200);
    }




    /**
     * @Route("/Image/{id}", name="Image", methods={"Get"})
     */
    public function deletelogo($id): JsonResponse
    {
        $logo = $this->getDoctrine()->getRepository(Equipe::class)->deleteOneLoGO($id);
        return new JsonResponse(['status' => 'logo deleted']);
    }




}
