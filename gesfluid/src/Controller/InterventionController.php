<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterventionController extends AbstractController
{
  #[Route('/intervention', name: 'app_intervention')]
  public function index(): Response
  {
    $this->denyAccessUnlessGranted(new Expression(
      'is_authenticated()'
    ));

    return $this->render('intervention/index.html.twig');
  }
}
