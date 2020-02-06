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
    /**
     * @Route("/visitor")
     */
{

    /**
     * @Route("/home", name="visitor_home")
     */
    public function homepage() {
        return $this->render('visitor/homepage.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact() {
        return $this->render('visitor/contact.html.twig');
    }
}