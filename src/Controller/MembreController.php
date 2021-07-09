<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


class MembreController extends ApiController{


    public function __construct(MembreRepository $repository)
    {
        $this->repository= $repository;
      
    }

    /**
     * @Route("/membre", name="membre")
     */
    public function index()
    {
        $personns = $this->repository->transformAll();
        return $this->respond($personns);
    }

    /**
     * @Route("/deletemembre/{id}", methods="DELETE")
     */
    public function deletepersonne($id, MembreRepository  $repository): JsonResponse
    {
        $offreEmploi =$repository->findOneBy(['id' => $id]);
        $repository->removeoffre($offreEmploi);
         return new JsonResponse(['status' => ' deleted']);
    }




}
