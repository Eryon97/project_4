<?php

namespace P4\BilletBundle\Controller;

use P4\BilletBundle\Entity\Formulaire;
use P4\BilletBundle\Entity\Billet;
use P4\BilletBundle\Form\FormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormulaireController extends Controller
{
    public function indexAction(Request $request)
    {  
        $formulaire = new Formulaire();
        $form = $this->get('form.factory')->create(FormulaireType::class, $formulaire);
        $somme = 0;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $date = $formulaire->getDate();
            $billets = $formulaire->getBillets();
            foreach ($billets as $billet) {
                $naissance = $billet->getNaissance();
                $age = $this->age($naissance, $date);
                $tarif = $billet->getTarif();
                if ($tarif == true) {
                    $prix = 10;
                } elseif ($tarif == false ) {
                    $prix = $this->calcul_prix($age);
                }
                $somme = $somme + $prix;
                $billet->setPrix($prix);
                $naissances[] = $naissance;
                $ages[] = $age;
                $tabPrix[] = $prix;
            }
            var_dump($date, $billets, $naissances, $ages, $tabPrix);
            return $this->render('P4BilletBundle:Default:commande.html.twig', array(
                'billets' => $billets,
                'total' => $somme,
            ));
        }

        return $this->render('P4BilletBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function age($naissance, $dateVisite) {
        list( $jour, $mois, $annee ) = sscanf( $naissance, "%d/%d/%d");
        list( $jourVisite, $moisVisite, $anneeVisite ) = sscanf( $dateVisite, "%d/%d/%d");
        $age = $anneeVisite - $annee;
        if ( $moisVisite < $mois){
            $age--;
        } if (($moisVisite == $mois) && ($jourVisite < $jour)){
            $age--;
        }
        return $age;
    }

    public function calcul_prix($age) {
        if ($age < 4 && $age >= 0) {
            $prix = 0;
        } else if ($age >= 4 && $age < 12) {
            $prix = 8;
        } else if ($age >=12 && $age < 60) {
            $prix = 16;
        } else if ($age >= 60) {
            $prix = 12;
        } else {}
        return $prix;
    }
}
