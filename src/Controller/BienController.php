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
        return $this->render('bien/consulterBien.html.twig', array('lesBiens' => $this->getBiens(), 'found' => 0));
    }
    
    /**
     * @Route("/modifierBien/{id}", name="modifierBien")
     */
    public function modifierBien(Request $query, int $id)
    {
        $lesBiens = $this->getBiens();
        foreach ($lesBiens as $bien) {
            if ($bien->getId() == $id) {
                $bienModifie = new Bien();
                $form = $this->createForm(BienType::class, $bienModifie);
                $form->handleRequest($query);
                if ($query->isMethod('POST')) {
                    if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $bien->setNbPiece($form['nb_piece']->getData());
                        $bien->setNbChambre($form['nb_chambre']->getData());
                        $bien->setSuperficie($form['superficie']->getData());
                        $bien->setPrix($form['prix']->getData());
                        $bien->setChauffage($form['chauffage']->getData());
                        $bien->setAnnee($form['annee']->getData());
                        $bien->setLocalisation($form['localisation']->getData());
                        $bien->setEtat($form['etat']->getData());
                        $bien->setIdType($form['id_type']->getData());
                        $em->flush();
                        return $this->render('bien/modifierBien.html.twig', array('bien' => $bien, 'form' => $form->createView(), 'success' => 1)); 
                    }
                }
                return $this->render('bien/modifierBien.html.twig', array('bien' => $bien, 'form' => $form->createView(), 'success' => 0));
            }
        }
        return $this->render('bien/consulterBien.html.twig', array('lesBiens' => $lesBiens, 'found' => -1));
    }
    
    /**
     * @Route("/supprimerBien/{id}", name="supprimerBien")
     */
    public function supprimerBien(Request $query, int $id)
    {
        return $this->render('bien/supprimerBien.html.twig', array('id' => $id));
    }
    
    /**
     * @Route("/suppressionBien/{id}", name="suppressionBien")
     */
    public function suppressionBien(Request $query, int $id)
    {
        $lesBiens = $this->getBiens();
        foreach ($lesBiens as $bien) {
            if ($bien->getId() == $id) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($bien);
                $em->flush();
            }
        }
        return $this->render('bien/consulterBien.html.twig', array('lesBiens' => $this->getBiens(), 'found' => 0));
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
    
    /**
     * @Route("/consulterTypesBien", name="consulterTypesBiens")
     */
    public function consulterTypesBien(Request $query)
    {
        return $this->render('bien/consulterTypesBien.html.twig', array('lesTypes' => $this->getTypes(), 'found' => 0));
    }
    
    /**
     * @Route("/supprimerType/{id}", name="supprimerType")
     */
    public function supprimerType(Request $query, int $id)
    {
        return $this->render('bien/supprimerType.html.twig', array('id' => $id));
    }
    
    /**
     * @Route("/suppressionType/{id}", name="suppressionType")
     */
    public function suppressionType(Request $query, int $id)
    {
        $lesTypes = $this->getTypes();
        foreach ($lesTypes as $type) {
            if ($type->getId() == $id) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($type);
                $em->flush();
            }
        }
        return $this->render('bien/consulterTypesBien.html.twig', array('lesTypes' => $this->getTypes(), 'found' => 0));
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
