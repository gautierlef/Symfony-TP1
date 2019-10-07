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
    
    /**
     * @Route("/consulterVisiteurs", name="consulterVisiteurs")
     */
    public function consulterVisiteurs(Request $query)
    {
        return $this->render('visiteur/consulterVisiteurs.html.twig', array('lesVisiteurs' => $this->getVisiteurs(), 'found' => 0));
    }
    
    /**
     * @Route("/modifierVisiteur/{id}", name="modifierVisiteur")
     */
    public function modifierVisiteur(Request $query, int $id)
    {
        $lesVisiteurs = $this->getVisiteurs();
        foreach ($lesVisiteurs as $visiteur) {
            if ($visiteur->getId() == $id) {
                $visiteurModifie = new Visiteur();
                $form = $this->createForm(VisiteurType::class, $visiteurModifie);
                $form->handleRequest($query);
                if ($query->isMethod('POST')) {
                    if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $visiteur->setNom($form['nom']->getData());
                        $visiteur->setPrenom($form['prenom']->getData());
                        $visiteur->setAdresse($form['adresse']->getData());
                        $visiteur->setTelephone($form['telephone']->getData());
                        $em->flush();
                        return $this->render('visiteur/modifierVisiteur.html.twig', array('visiteur' => $visiteur, 'form' => $form->createView(), 'success' => 1)); 
                    }
                }
                return $this->render('visiteur/modifierVisiteur.html.twig', array('visiteur' => $visiteur, 'form' => $form->createView(), 'success' => 0));
            }
        }
        return $this->render('visiteur/consulterVisiteurs.html.twig', array('lesVisiteurs' => $lesVisiteurs, 'found' => -1));
    }
    
    /**
     * @Route("/supprimerVisiteur/{id}", name="supprimerVisiteur")
     */
    public function supprimerVisiteur(Request $query, int $id)
    {
        return $this->render('visiteur/supprimerVisiteur.html.twig', array('id' => $id));
    }
    
    /**
     * @Route("/suppressionVisiteur/{id}", name="suppressionVisiteur")
     */
    public function suppressionVisiteur(Request $query, int $id)
    {
        $lesVisiteurs = $this->getVisiteurs();
        foreach ($lesVisiteurs as $visiteur) {
            if ($visiteur->getId() == $id) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($visiteur);
                $em->flush();
            }
        }
        return $this->render('visiteur/consulterVisiteurs.html.twig', array('lesVisiteurs' => $this->getVisiteurs(), 'found' => 0));
    }
    
    public function getVisiteurs() {
        $lesVisiteurs = $this->getDoctrine()->getRepository(\App\Entity\Visiteur::class)->findAll();
        return $lesVisiteurs;
    }
}
