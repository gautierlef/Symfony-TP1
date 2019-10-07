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
    
    /**
     * @Route("/consulterVisites", name="consulterVisites")
     */
    public function consulterVisites(Request $query)
    {
        return $this->render('visite/consulterVisites.html.twig', array('lesVisites' => $this->getVisites(), 'found' => 0));
    }
    
    /**
     * @Route("/modifierVisite/{id}", name="modifierVisite")
     */
    public function modifierVisite(Request $query, int $id)
    {
        $lesVisites = $this->getVisites();
        foreach ($lesVisites as $visite) {
            if ($visite->getId() == $id) {
                $visiteModifie = new Visite();
                $form = $this->createForm(VisiteType::class, $visiteModifie);
                $form->handleRequest($query);
                if ($query->isMethod('POST')) {
                    if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $visite->setIdVisiteur($form['id_visiteur']->getData());
                        $visite->setIdBien($form['id_bien']->getData());
                        $visite->setSuite($form['suite']->getData());
                        $em->flush();
                        return $this->render('visite/modifierVisite.html.twig', array('visite' => $visite, 'form' => $form->createView(), 'success' => 1)); 
                    }
                }
                return $this->render('visite/modifierVisite.html.twig', array('visite' => $visite, 'form' => $form->createView(), 'success' => 0));
            }
        }
        return $this->render('visite/consulterVisites.html.twig', array('lesVisites' => $lesVisites, 'found' => -1));
    }
    
    /**
     * @Route("/supprimerVisite/{id}", name="supprimerVisite")
     */
    public function supprimerVisite(Request $query, int $id)
    {
        return $this->render('visite/supprimerVisite.html.twig', array('id' => $id));
    }
    
    /**
     * @Route("/suppressionVisite/{id}", name="suppressionVisite")
     */
    public function suppressionVisite(Request $query, int $id)
    {
        $lesVisites = $this->getVisites();
        foreach ($lesVisites as $visite) {
            if ($visite->getId() == $id) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($visite);
                $em->flush();
            }
        }
        return $this->render('visite/consulterVisites.html.twig', array('lesVisites' => $this->getVisites(), 'found' => 0));
    }
    
    public function getVisites() {
        $lesVisites = $this->getDoctrine()->getRepository(\App\Entity\Visite::class)->findAll();
        return $lesVisites;
    }
}
