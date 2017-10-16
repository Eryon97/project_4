<?php

namespace P4\BilletBundle\Controller;

use P4\BilletBundle\Entity\Formulaire;
use P4\BilletBundle\Entity\Billet;
use P4\BilletBundle\Form\FormulaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormulaireController extends Controller
{
    public function indexAction(Request $request)
    {  
        $formulaire = new Formulaire();
        $form = $this->get('form.factory')->create(FormulaireType::class, $formulaire);
        $somme = 0;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $calculs = $this->container->get('p4_billet.calculs');
            $date = $formulaire->getDate();
            $billets = $formulaire->getBillets();
            foreach ($billets as $billet) {
                $naissance = $billet->getNaissance();
                $age = $calculs->age($naissance, $date);
                $tarif = $billet->getTarif();
                if ($tarif == true) {
                    $prix = 10;
                } elseif ($tarif == false ) {
                    $prix = $calculs->prix($age);
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
}