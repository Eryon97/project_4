<?php

namespace P4\BilletBundle\Controller;

use P4\BilletBundle\Entity\Formulaire;
use P4\BilletBundle\Entity\Billets;
use P4\BilletBundle\Entity\Start;
use P4\BilletBundle\Form\FormulaireType;
use P4\BilletBundle\Form\StartFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class FormulaireController extends Controller
{
    
    public function indexAction(Request $request)
    {  
        $formulaire = new Start();
        $form = $this->createForm(StartFormType::class, $formulaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $_SESSION['date'] = $formulaire->getDate();
            $_SESSION['nombre'] = $formulaire->getNombre();
            $_SESSION['email'] = $formulaire->getEmail();
            $_SESSION['type'] = $formulaire->getType();
        
            return $this->redirectToRoute('p4_billet_billets');       
        }

        return $this->render('P4BilletBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function billetsAction(Request $request)
    {  
        $formulaire = new Formulaire();
        $nombre = $_SESSION['nombre'];
        for ( $i=0; $i<$nombre; $i++)
        {
            $formulaire->getBillets()->add(new Billets());
        }
        $form = $this->createForm(FormulaireType::class, $formulaire);

        $formulaire->setDate($_SESSION['date']);
        $formulaire->setEmail($_SESSION['email']);
        $formulaire->setNombre($_SESSION['nombre']);
        $formulaire->setType($_SESSION['type']);

        $_SESSION['formulaire'] = $formulaire;


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $forms = $this->container->get('p4_billet.forms');
            $billets = $forms->billets($formulaire);
            $_SESSION['billets'] = $billets;
        
            return $this->redirectToRoute('p4_billet_resume');       
        }

        return $this->render('P4BilletBundle:Default:formBillets.html.twig', array(
            'form' => $form->createView(),
            'session' => $_SESSION,
        ));
    }

    public function resumeAction(Request $request)
    {
        if ( $_SESSION['billets'])
        {
            $formulaire = $_SESSION['formulaire'];
            $billets = $_SESSION['billets'];
            $somme = $_SESSION['somme'];

            return $this->render('P4BilletBundle:Default:commande.html.twig', array(
                'billets' => $billets,
                'somme' => $somme,
                'formulaire' => $formulaire,
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