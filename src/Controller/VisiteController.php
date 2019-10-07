<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Visite;
use App\Form\VisiteType;

class VisiteController extends AbstractController
{
    /**
     * @Route("/ajouterVisite", name="ajouterVisite")
     */
    public function ajouterVisiteur(Request $query)
    {
        $visiteAjoutee = new Visite();
        $form = $this->createForm(VisiteType::class, $visiteAjoutee);
        $form->handleRequest($query);
        if ($query->isMethod('POST')) {
            if ($form->isValid()) {
                $lesVisites = $this->getVisites();
                foreach ($lesVisites as $visite) {
                    if ($visite->getIdVisiteur() == $form['id_visiteur']->getData() && $visite->getIdBien() == $form['id_bien']->getData()) {
                        return $this->render('visite/ajouterVisite.html.twig', array('form' => $form->createView(), 'success' => -1));
                    }
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($visiteAjoutee);
                $em->flush();
                return $this->render('visite/ajouterVisite.html.twig', array('form' => $form->createView(), 'success' => 1)); 
            }
        }
        return $this->render('visite/ajouterVisite.html.twig', array('form' => $form->createView(), 'success' => 0));
    }
    
    public function getVisites() {
        $lesVisites = $this->getDoctrine()->getRepository(\App\Entity\Visite::class)->findAll();
        return $lesVisites;
    }
}
