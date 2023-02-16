<?php

namespace App\Controller;

use App\Repository\InterventionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiInterventionController extends AbstractController
{
  #[Route('/api/interventionsByUser/{id}', name: 'app_interventions_by_user')]
  public function index($id, InterventionRepository $interventionRepository): Response
  {
    $result = $interventionRepository->findByUser($id);
    return $this->json($result);
  }
}
