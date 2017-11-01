<?php

namespace P4\BilletBundle\Controller;

use P4\BilletBundle\Entity\Formulaire;
use P4\BilletBundle\Entity\Billets;
use P4\BilletBundle\Form\FormulaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            $_SESSION['formulaire'] = $formulaire;
            return $this->redirectToRoute('p4_billet_resume');
        }

        return $this->render('P4BilletBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function resumeAction(Request $request)
    {
        if ( $_SESSION['billets'])
        {
            $billets = $_SESSION['billets'];
            $somme = $_SESSION['somme'];

            return $this->render('P4BilletBundle:Default:commande.html.twig', array(
                'billets' => $billets,
                'somme' => $somme,
            ));
        }
    }

    public function validationAction(Request $request)
    {
        $delivery = $_SESSION['email'];
        $billets = $_SESSION['billets'];
        $formulaire = $_SESSION['formulaire'];
        $message = (new \Swift_Message('Confirmation de commande'))
        ->setFrom('eryongaming@gmail.com')
        ->setTo($delivery)
        ->setBody(
            $this->renderView('P4BilletBundle:Emails:registration.html.twig', array( 'billets' => $billets )),
            'text/html'
        );

        $this->get('mailer')->send($message);

        $em = $this->getDoctrine()->getManager();
        foreach ($billets as $billet)
        {
            $em->persist($billet);
        }
        $em->persist($formulaire);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Paiement accepté, merci de votre commande, un email va vous etre envoyé.');

        return $this->redirectToRoute('p4_billet_homepage');
    }
}