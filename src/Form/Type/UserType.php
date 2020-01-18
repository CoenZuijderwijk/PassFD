<?php


namespace App\Form\Type;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add('username', TextType::class, [
            'label' => 'Username'
        ])
        ->add('password', TextType::class, [
            'label' => 'Password'
        ])
        ->add('first_name', TextType::class, [
            'label' => 'First name'
        ])
        ->add('last_name', TextType::class, [
            'label' => 'Last name'
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email'
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Register'
        ])
    ;
    }

}