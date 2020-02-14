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
            return $this->redirectToRoute('member_home');
        }
        return $this->render('member/clothes_add.html.twig', ['form' => $form->createView(),
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
            'images' => $foto
        ]);
    }

    /**
     * @Route("/clothes/{id}", name="overzicht_aangepast")
     */
    public function overzichtAangepast($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $foto = $em->getRepository(ClothingPiece::class)->findBy([
            'user' => $user,
            'Type' => $id

        ]);
        return $this->render('member/overzicht.html.twig', [
            'images' => $foto
        ]);
    }

    /**
     * @Route("/clothes/select/{id}", name="clothes_select")
     */
    public function clothes_select($id) {
        $em = $this->getDoctrine()->getManager();
        $cpiece = $em->getRepository(ClothingPiece::class)->find($id);
        $selected = $cpiece->getSelected();
        if($selected == false){
            $cpiece->setSelected(true);
        } else if($selected == true)
        {
            $cpiece->setSelected(false);
        }
        $em->persist($cpiece);
        $em->flush();
        return $this->redirectToRoute('overzicht');
    }

    /**
     * @Route("/outfit", name="outfit")
     */
    public function outfit() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $clothes = $em->getRepository(ClothingPiece::class)->findBy([
            'user' => $user,
            'selected' => true
        ]);
        $i = 0;
        $size = count($clothes);
        if($size > 2) {
            //error ofzo?
        } elseif( $size == 2) {
            foreach($clothes as $clothes){
            $type = $clothes->getType();
            switch ($type) {
                case 'tshirt' : $bovenstuk = $em->getRepository(ClothingPiece::class)->findBy([
                    'user' => $user,
                    'selected' => true,
                    'Type' => 'tshirt'
                ]); break;
                case 'shirt' : $bovenstuk = $em->getRepository(ClothingPiece::class)->findBy([
                    'user' => $user,
                    'selected' => true,
                    'Type' => 'shirt'
                ]); break;
                case 'blousse' : $bovenstuk = $em->getRepository(ClothingPiece::class)->findBy([
                    'user' => $user,
                    'selected' => true,
                    'Type' => 'blousse'
                ]); break;
                case 'trui': $bovenstuk = $em->getRepository(ClothingPiece::class)->findBy([
                    'user' => $user,
                    'selected' => true,
                    'Type' => 'trui'
                ]);break;
                case 'rok': $onderstuk = $em->getRepository(ClothingPiece::class)->findBy([
                    'user' => $user,
                    'selected' => true,
                    'Type' => 'rok']);
                    break;
                case 'broek' :$onderstuk = $em->getRepository(ClothingPiece::class)->findBy([
                    'user' => $user,
                    'selected' => true,
                    'Type' => 'broek']);
                break;
                default: break;
            }
            $i++;
            }
        } elseif($clothes == 1){
            //jurk
            return $this->render('member/outfit.html.twig', [
                'jurk' => $clothes,
            ]);
        }
        $clothes = $em->getRepository(ClothingPiece::class)->findBy([
            'user' => $user,
            'selected' => true
        ]);
        return $this->render('member/outfit.html.twig', [
            'images' => $clothes,
            'bovenstuk' => $bovenstuk[0],
            'onderstuk' => $onderstuk[0]
        ]);
    }

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
