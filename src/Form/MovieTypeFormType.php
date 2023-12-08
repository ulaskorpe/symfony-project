<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-23 w-full h-20 text-6xl',
                    'placeholder'=>'enter title'
                ),
                'label'=>false,
                'required'=>false,
            ])
            ->add('releaseYear',IntegerType::class,[
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-23 w-full h-20 text-6xl',
                    'placeholder'=>'enter year'
                ),
                'label'=>false,
                'required'=>false,
            ])
            ->add('description',TextareaType::class,[
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-23 w-full h-60 text-6xl',
                    'placeholder'=>'enter desc'
                ),
                'label'=>false,
                'required'=>false,
            ])
            ->add('imagePath',FileType::class, array(
                'required'=>false,
                'mapped'=>false,
                

            ))
            // ->add('imagePath',FileType::class ,[
            //     'attr'=>array(
            //         'class'=>'py-10',
            //         'placeholder'=>'select image'
            //     ),
            //     'label'=>false
            // ])
            ///->add('actors')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
