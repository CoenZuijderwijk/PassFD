<?php

namespace App\Controller;

use App\Entity\ClothingPiece;
use App\Entity\User;
use App\Form\Type\ClothingPieceType;
use App\Form\Type\FaceImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
    /**
     * @Route("/member")
     */
{
    /**
     * @Route("/home", name="member_home")
     */
    public function homepage() {
        return $this->render('member/homepage.html.twig');
    }

    /**
     * @Route("/clothes_add", name="clothes_add")
     */
    public function formtest(Request $request)
    {
        $clothing = new ClothingPiece();

        $form = $this->createForm(ClothingPieceType::class, $clothing);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /**$var UploadedFile $imageFile*/
            $imageFile = $form->get('image_file_name')->getData();
            if($imageFile) {
                $uri = $clothing->setUri($imageFile);
                //Move the file to the directory where images are stored
            }
            $clothing = $form->getData();
            $user = $this->getUser();
            $clothing->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($clothing);
            $em->flush();
            return $this->redirectToRoute('/home');
        }
        return $this->render('visitor/clothes_add.html.twig', ['form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/overzicht", name="overzicht")
     */
    public function overzicht() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $foto = $em->getRepository(ClothingPiece::class)->findBy([
            'user' => $user
        ]);

        return $this->render('member/overzicht.html.twig', [
            'image' => $foto
        ]);}

    /**
     * @Route("/face", name="face")
     */
    public function face(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $person = $em->getRepository(User::class)->find($user);

        $form = $this->createForm(FaceImageType::class, $person);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /**$var UploadedFile $imageFile*/
            $imageFile = $form->get('face_image')->getData();
            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $imageownername = $this->getUser()->getUsername();
                $safeFilename = 'face' .'-'. $imageownername;
                $newFilename = $safeFilename.'-'.uniqid().'-'.$imageFile->guessExtension();

                //Move the file to the directory where images are stored
                try{
                    $imageFile->move($this->getParameter('face_directory'), $newFilename);
                } catch (FileException $e) {
                    //handle excetion if something happens during file upload
                }
                $person->setFaceImage($newFilename);
            }
            $clothing = $form->getData();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute('/home');
        }
        return $this->render('member/face.html.twig', ['form' => $form->createView(),
        ]);


    }
}
