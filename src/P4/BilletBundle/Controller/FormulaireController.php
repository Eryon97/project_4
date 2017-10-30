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

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $forms = $this->container->get('p4_billet.forms');
            $billets = $forms->billets($formulaire);
            $somme = $_SESSION['somme'];
            $_SESSION['billets'] = $billets;
            return $this->render('P4BilletBundle:Default:commande.html.twig', array(
                'billets' => $billets,
                'somme' => $somme,
            ));
        }

        return $this->render('P4BilletBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function validationAction(Request $request)
    {
        $delivery = $_SESSION['email'];
        $billets = $_SESSION['billets'];
        $message = (new \Swift_Message('Confirmation de commande'))
        ->setFrom('eryongaming@gmail.com')
        ->setTo($delivery)
        ->setBody(
            $this->renderView('P4BilletBundle:Emails:registration.html.twig', array( 'billets' => $billets )),
            'text/html'
        );

        $this->get('mailer')->send($message);

        $request->getSession()->getFlashBag()->add('info', 'Paiement accepté, un email va vous etre envoyé.');

        return $this->redirectToRoute('p4_billet_homepage');
    }
}