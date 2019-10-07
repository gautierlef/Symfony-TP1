<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Type;
use App\Entity\Bien;
use App\Form\TypeBienType;
use App\Form\BienType;

class BienController extends AbstractController
{
    /**
     * @Route("/ajouterBien", name="ajouterBien")
     */
    public function ajouterBien(Request $query)
    {
        $bienAjoute = new Bien();
        $form = $this->createForm(BienType::class, $bienAjoute);
        $form->handleRequest($query);
        if ($query->isMethod('POST')) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($bienAjoute);
                $em->flush();
                return $this->render('bien/ajouterBien.html.twig', array('form' => $form->createView(), 'success' => 1)); 
            }
        }
        return $this->render('bien/ajouterBien.html.twig', array('form' => $form->createView(), 'success' => 0));
    }
    
    /**
     * @Route("/consulterBien", name="consulterBien")
     */
    public function consulterBien(Request $query)
    {
        return $this->render('bien/consulterBien.html.twig', array('lesBiens' => $this->getBiens()));
    }
        
    /**
     * @Route("/ajouterTypeBien", name="ajouterTypeBien")
     */
    public function ajouterTypeBien(Request $query)
    {
        $typeAjoute = new Type();
        $form = $this->createForm(TypeBienType::class, $typeAjoute);
        $form->handleRequest($query);
        if ($query->isMethod('POST')) {
            if ($form->isValid()) {
                $lesTypes = $this->getTypes();
                foreach ($lesTypes as $type) {
                    if ($type->getLibelle() == $form['libelle']->getData()) {
                        return $this->render('bien/ajouterTypeBien.html.twig', array('form' => $form->createView(), 'success' => -1));
                    }
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($typeAjoute);
                $em->flush();
                return $this->render('bien/ajouterTypeBien.html.twig', array('form' => $form->createView(), 'success' => 1)); 
            }
        }
        return $this->render('bien/ajouterTypeBien.html.twig', array('form' => $form->createView(), 'success' => 0));
    }
    
    public function getTypes() {
        $lesTypes = $this->getDoctrine()->getRepository(\App\Entity\Type::class)->findAll();
        return $lesTypes;
    }
    
    public function getBiens() {
        $lesBiens = $this->getDoctrine()->getRepository(\App\Entity\Bien::class)->findAll();
        return $lesBiens;
    }
}
