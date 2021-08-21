<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Candidature;
use App\Entity\OffreEmploi;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\repository\OffreEmploiRepository;
use Doctrine\ORM\EntityManagerInterface;




class CandidatureController extends AbstractController
{
   
    /**
    * @Route("/createCandidature",name="createCandidature" , methods="POST")
    */
    
    public function createArticle(Request $request )
{
        $file =  new Candidature();
        $uploadedImage = $request->files->get('cv');
        /**
         * @var UploadedFile $image
         */
        $image = $uploadedImage;
        $imageName = md5(uniqid()) . '.' . $image->guessExtension();
        $image->move($this->getParameter('image_directory'), $imageName);
        $file->setCv($imageName);

        $file->setNom($request->get("nom"));
        $file->setPrenom($request->get("prenom"));
        $file->setEmail($request->get("email"));

    
    



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









    
}
