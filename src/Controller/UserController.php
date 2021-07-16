<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\BackendAuthenticator; 
class UserController extends AbstractController{
   

  /**
     * @Route("/get/profile", name="api_get_user", methods="GET")
     * 
    */

    // public function getUserAction()
    // {
    //     $user = $this->security ->getUser();
    //     // $user = $this->get('security.token_storage')->getToken()->getUser();
    //     $serializer = $this->get('jms_serializer');
    //     $jsonContent = $serializer->serialize($user, 'json');
 
    //     $response = new Response(json_encode(array('response' => 'OK', 'data'=> $jsonContent)));
    //     $response->headers->set('Content-Type', 'application/json');
    //     return  $response;
    // }


  /**
     * @Route("/get/profile", name="api_get_user", methods="GET")
     * 
    */
  
   public function getUserAction(){
        // $user = $this->container->get('security.token_storage')->getToken()->getUser()->getRidUtilisateur();
        // echo print_r($this->container,true);
        // // $user = $this->getUser();
        // // $user = $this->get('security.token_storage')->getToken()->getUser();
        // $serializer = $this->get('serializer');
        // $jsonContent = $serializer->serialize($user, 'json');
        // $response = new Response(json_encode(array('response' => 'OK', 'data'=> $jsonContent)));
        // $response->headers->set('Content-Type', 'application/json');
        // return  $response;

         // usually you'll want to make sure the user is authenticated first
    // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


    // returns your User object, or null if the user is not authenticated
    // use inline documentation to tell your editor your exact User class
    // /** @var \App\Entity\User $user */

    $user = $this->get('security.token_storage')->getToken()->getUser();

    // Call whatever methods you've added to your User class
    // For example, if you added a getFirstName() method, you can use that.
    return new Response($user);

   }

      
    

}