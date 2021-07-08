<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Equipe;


use App\Repository\EquipeRepository; 
class EquipeController extends ApiController
{

    public function __construct(EquipeRepository $repository)
    {
        $this->repository= $repository;
      
    }
    /**
     * @Route("api/personne", name="personne")
     */
    public function index()
    {
        $personns = $this->repository->transformAll();
        return $this->respond($personns);
    }

    /** 
    * @Route("/createpersonne", name="createpersonne")
    */
    public function createEquipe(Request $request ,EquipeRepository  $equipeRepository,EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        if (! $request) {
            return $this->respondValidationError(' valid request ?');
        }
        // validate the title
        if (! $request->get("nom")) {
            return $this->respondValidationError('Please provide a valid nom !');}
        if (! $request->get("prenom")) {
                return $this->respondValidationError('Please provide a valid prenom !');}
        if (! $request->get("role")) {
                    return $this->respondValidationError('Please provide a valid role !');}
        if (! $request->get("Email")) {
                        return $this->respondValidationError('Please provide a valid Email !');}
            
        // persist the new movie
        $personn = new Equipe();
        $personn->setNom($request->get('nom'));
        $personn->setPrenom($request->get('prenom'));
        $personn->setRole($request->get('role'));
        $personn->setEmail($request->get('Email'));
        $em->persist($personn);
        $em->flush();
        return $this->respondCreated($equipeRepository-> findAll($personn));
    }




}
