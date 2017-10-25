<?php

namespace P4\BilletBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OrderController extends Controller
{
     public function checkoutAction()
     {
        \Stripe\Stripe::setApiKey($this->getParameter("stripe_sk"));
 
        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];
        $somme = $_SESSION['somme'];

        var_dump($_SESSION);
 
        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $somme, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Musée du Louvre"
            ));
            return $this->redirectToRoute("p4_billet_confirm");
        } catch(\Stripe\Error\Card $e) {
            
            return $this->redirectToRoute("p4_billet_homepage");
        }
    }
}