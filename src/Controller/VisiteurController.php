<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Visiteur;
use App\Form\VisiteurType;

class VisiteurController extends AbstractController
{
    /**
     * @Route("/ajouterVisiteur", name="ajouterVisiteur")
     */
    public function ajouterVisiteur(Request $query)
    {
        $visiteurAjoute = new Visiteur();
        $form = $this->createForm(VisiteurType::class, $visiteurAjoute);
        $form->handleRequest($query);
        if ($query->isMethod('POST')) {
            if ($form->isValid()) {
                $lesVisiteurs = $this->getVisiteurs();
                foreach ($lesVisiteurs as $visiteur) {
                    if ($visiteur->getPrenom() == $form['prenom']->getData() && $visiteur->getNom() == $form['nom']->getData() && $visiteur->getAdresse() == $form['adresse']->getData() && $visiteur->getTelephone() == $form['telephone']->getData()) {
                        return $this->render('visiteur/ajouterVisiteur.html.twig', array('form' => $form->createView(), 'success' => -1));
                    }
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($visiteurAjoute);
                $em->flush();
                return $this->render('visiteur/ajouterVisiteur.html.twig', array('form' => $form->createView(), 'success' => 1)); 
            }
        }
        return $this->render('visiteur/ajouterVisiteur.html.twig', array('form' => $form->createView(), 'success' => 0));
    }
    
    public function getVisiteurs() {
        $lesVisiteurs = $this->getDoctrine()->getRepository(\App\Entity\Visiteur::class)->findAll();
        return $lesVisiteurs;
    }
}
