<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Image;
use App\Entity\Rubrique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('rubrique', EntityType::class, [
                'class'        => Rubrique::class,
                'choice_label' => 'libelle'
            ])
//            ->add('author')
            ->add('images', FileType::class, [
//                'class' => Image::class,
                'mapped'   => false,
                'multiple' => true,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Annonce::class,
                               ]);
    }
}
