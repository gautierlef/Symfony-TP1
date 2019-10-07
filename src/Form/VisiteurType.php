<?php

namespace App\Form;

use App\Entity\Visiteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VisiteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom : ', 'attr' => array('class' => 'form-control')))
            ->add('prenom', TextType::class, array('label' => 'Prénom : ', 'attr' => array('class' => 'form-control')))
            ->add('adresse', TextType::class, array('label' => 'Adresse : ', 'attr' => array('class' => 'form-control')))
            ->add('telephone', TextType::class, array('label' => 'Téléphone : ', 'attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visiteur::class,
        ]);
    }
}
