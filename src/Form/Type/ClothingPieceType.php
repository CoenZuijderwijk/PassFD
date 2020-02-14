<?php


namespace App\Form\Type;

use App\Entity\ClothingPiece;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ClothingPieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name'
            ])
            ->add('color', TextType::class, [
                'label' => 'color'
            ])
            ->add('style', TextType::class, [
                'label' => 'style'
            ])
            ->add('size', TextType::class, [
                'label' => 'size'
            ])
            ->add('type', ChoiceType::class,
                [
                    'choices' => [
                        'Broek' => 'broek',
                        'T-shirt' => 'tshirt',
                        'shirt' => 'shirt',
                        'blousse' => 'blousse',
                        'rok' => 'rok',
                        'jurk' => 'jurk',
                        'trui' => 'trui'
                    ]
                ])
            ->add('image_file_name', FileType::class, [
                'label' => 'Outfit image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '8Mi',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Please upload a JPEG or PNG image',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
            ])
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClothingPiece::class,
        ]);
    }

}