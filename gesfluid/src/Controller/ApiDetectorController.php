<?php

namespace App\Controller;

use App\Repository\AccessoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiDetectorController extends AbstractController
{
  #[Route('/api/detectors', name: 'app_detectors')]
  public function index(AccessoryRepository $accessoryRepository): Response
  {
    $result = $accessoryRepository->getDetectors();
    return $this->json($result);
  }
}
