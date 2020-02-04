<?php


namespace App\Controller;


use App\Entity\ClothingPiece;
use App\Entity\User;
use App\Form\Type\ClothingPieceType;
use App\Form\Type\FaceImage;
use App\Form\Type\FaceImageType;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class VisitorController extends AbstractController
{
    /**
     * @Route("/home", name="/home")
     */
    public function homepage() {
        return $this->render('Visitor/Homepage.html.twig');
    }

    /**
     * @Route("/clothes", name="clothes")
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
        return $this->render('Visitor/formtest.html.twig', ['form' => $form->createView(),
            ]);


    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('/home');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Visitor/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/register")
     */
    public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder) {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user=$form->getData();

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('Visitor/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/overzicht")
     */
    public function overzicht() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $person = $em->getRepository(User::class)->find($user);
        $face = $this->getUser()->getFaceImage();
        return $this->render('Member/show_image.html.twig', ['user' => $person, 'face' => $face]);
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
        return $this->render('Visitor/face.html.twig', ['form' => $form->createView(),
        ]);


    }
    /**
     * @Route("/test", name="test")
     */
    public function testen() {
        return $this->render('Visitor/test.html.twig');
    }

    /**
     * @Route("/img_to_uri", name="itu")
     */
    public function image() {
        $em = $this->getDoctrine()->getManager();
        $foto = $em->getRepository(ClothingPiece::class)->find(8);
        $f_naam = $foto->getUri();

        return $this->render('Member/test.html.twig', [
            'image' => $f_naam
        ]);
    }

    /**
     * @Route("/test2", name="test2")
     */
    public function test() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $foto = $em->getRepository(ClothingPiece::class)->findBy([
            'user' => $user
        ]);

        return $this->render('Member/overzicht.html.twig', [
            'image' => $foto
        ]);
    }


}