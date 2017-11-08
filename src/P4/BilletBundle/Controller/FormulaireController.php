<?php

namespace P4\BilletBundle\Controller;

use P4\BilletBundle\Entity\Formulaire;
use P4\BilletBundle\Entity\Billets;
use P4\BilletBundle\Form\FormulaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

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
            $date = $formulaire->getDate();
            $nbBillet = $formulaire->getNombre();
            $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('P4BilletBundle:Billets');

            $qb= $repository->createQueryBuilder('t');
            $qb->select('count(t.date)');
            $qb->where('t.date = :date');
            $qb->setParameter('date', $date);
            $nombre= $qb->getQuery()->getSingleScalarResult();
            $nombre = $nombre + $nbBillet;
            $_SESSION['nb'] = $nombre;
            
            if ($nombre >= 3)
            {
                $request->getSession()->getFlashBag()->add('warning', 'Attention, la limite d\'accueil du musée est atteinte pour cette date, veuillez choisir une autre date.');
                return $this->redirectToRoute('p4_billet_homepage');
            } else {
                return $this->redirectToRoute('p4_billet_resume');
            }            
        }

        return $this->render('P4BilletBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function resumeAction(Request $request)
    {
        if ( $_SESSION['billets'])
        {
            $formulaire = $_SESSION['formulaire'];
            $billets = $_SESSION['billets'];
            $somme = $_SESSION['somme'];
            $nb = $_SESSION['nb'];

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