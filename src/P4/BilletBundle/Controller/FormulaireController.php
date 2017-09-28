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
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $date = $formulaire->getDate();
            $billets = $formulaire->getBillets();
            foreach ($billets as $billet) {
                $naissance = $billet->getNaissance();
                $age = $this->age($naissance, $date);
                $naissances[] = $naissance;
                $ages[] = $age;
            }
            var_dump($date, $billets, $naissances, $ages);
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
}
