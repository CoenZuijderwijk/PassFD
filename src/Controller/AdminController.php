<?php

namespace App\Controller;

use App\Entity\ClothingPiece;
use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
    /**
     * @Route("/admin")
     */
{
    /**
     * @Route("/home", name="admin_home")
     */
    public function homepage() {
        return $this->render('admin/homepage.html.twig');
    }

    /**
     * @Route("/overzicht_members", name="overzicht_members")
     */
    public function overzicht_members() {
        $users = $this->getDoctrine()->getManager()->getRepository(user::class)->findAll();

        return $this->render('admin/overzicht_members.html.twig', [
            'users' => $users]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/overzicht_clothing", name="overzicht_clothing")
     */
    public function overzicht_clothing() {
        $em = $this->getDoctrine()->getManager();
        $foto = $em->getRepository(ClothingPiece::class)->findAll();

        return $this->render('admin/overzicht_clothing.html.twig', [
            'images' => $foto
        ]);}

    /**
     * @Route("/{id}", name="clothing_show", methods={"GET"})
     */
    public function clothing_show(ClothingPiece $clothingPiece): Response
    {
        return $this->render('admin/clothing_show.html.twig', [
            'cl' => $clothingPiece,
        ]);
    }

}
