<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if ($this->getUser()->getUserIdentifier() != $user->getUserIdentifier()) {
            // seul l'admin peut voir les infos de tout le monde
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'avez pas accès à ceci.');
        } 
        return $this->render('client/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->getUser()->getUserIdentifier() != $user->getUserIdentifier()) {
            // autorisé l'accés qu'a l'administateur
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'avez pas accès à ceci.');
        }
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER); // app_hmom car app.user.id et app_client_show ne fonctionnent pas pour la redirection aprés la modif du profil ou isverified
        }

        return $this->renderForm('client/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
