<?php

namespace P4\BilletBundle\Controller;

use P4\BilletBundle\Entity\Formulaire;
use P4\BilletBundle\Entity\Billet;
use P4\BilletBundle\Form\FormulaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swiftmailer\Swiftmailer;

class FormulaireController extends Controller
{
    public function indexAction(Request $request)
    {  
        $formulaire = new Formulaire();
        $form = $this->createForm(FormulaireType::class, $formulaire);
        $somme = 0;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $calculs = $this->container->get('p4_billet.calculs');
            $date = $formulaire->getDate();
            $billets = $formulaire->getBillets();
            $mail = $formulaire->getEmail();
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
            $_SESSION['somme'] = ($somme * 100);
            $_SESSION['email'] = $mail;
            var_dump($date, $billets, $naissances, $ages, $tabPrix);
            return $this->render('P4BilletBundle:Default:commande.html.twig', array(
                'billets' => $billets,
                'somme' => $somme,
            ));
        }

        return $this->render('P4BilletBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function validationAction()
    {
        $delivery = $_SESSION['email'];
        var_dump($delivery);
        $message = (new \Swift_Message('Confirmation Email'))
        ->setFrom('eryongaming@gmail.com')
        ->setTo($delivery)
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig'
            ),
            'text/html'
        );

        $this->get('mailer')->send($message);

        return $this->render('P4BilletBundle:Default:validation.html.twig');
    }
}