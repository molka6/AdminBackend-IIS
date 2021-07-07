<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EquipeRepository; 
class EquipeController extends ApiController
{

    public function __construct(EquipeRepository $repository)
    {
        $this->repository= $repository;
      
    }
    /**
     * @Route("personne", name="personne")
     */
    public function index()
    {
        $personns = $this->repository->transformAll();
        return $this->respond($personns);
    }


}
