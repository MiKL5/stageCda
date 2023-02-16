<?php

namespace App\Controller;

use App\Repository\ContainerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiContainerController extends AbstractController
{
  #[Route('/api/containersByFluid/{id}', name: 'app_containers_by_fluid')]
  public function index($id, ContainerRepository $containerRepository): Response
  {
    $result = $containerRepository->findByFluid($id);
    return $this->json($result);
  }
}
