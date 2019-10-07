<?php

namespace App\Form;

use App\Entity\Bien;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb_piece', NumberType::class, array('label' => 'Nombre de pièces : ', 'attr' => array('class' => 'form-control')))
            ->add('nb_chambre', NumberType::class, array('label' => 'Nombre de chambres : ', 'attr' => array('class' => 'form-control')))
            ->add('superficie', NumberType::class, array('label' => 'Superficie : ', 'attr' => array('class' => 'form-control')))
            ->add('prix', NumberType::class, array('label' => 'Prix : ', 'attr' => array('class' => 'form-control')))
            ->add('chauffage', NumberType::class, array('label' => 'Chauffage : ', 'attr' => array('class' => 'form-control')))
            ->add('annee', TextType::class, array('label' => 'Année : ', 'attr' => array('class' => 'form-control')))
            ->add('localisation', TextType::class, array('label' => 'Localisation : ', 'attr' => array('class' => 'form-control')))
            ->add('etat', TextType::class, array('label' => 'Etat : ', 'attr' => array('class' => 'form-control')))
            ->add('id_type', EntityType::class, array('class' => Type::class, 'choice_label' => 'libelle', 'label' => 'Type :', 'attr' => array('class' => 'Type')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
