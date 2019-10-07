<?php

namespace App\Form;

use App\Entity\Visite;
use App\Entity\Visiteur;
use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('suite', TextType::class, array('label' => 'Suite : ', 'attr' => array('class' => 'form-control')))
            ->add('id_bien', EntityType::class, array('class' => Bien::class, 'choice_label' => 'id', 'label' => 'Bien :', 'attr' => array('class' => 'Bien')))
            ->add('id_visiteur', EntityType::class, array('class' => Visiteur::class, 'choice_label' => 'nom', 'label' => 'Visiteur :', 'attr' => array('class' => 'Visiteur')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
