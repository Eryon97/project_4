<?php

namespace P4\BilletBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * This controller is used to simulate an order from a customer.
 * Class OrderController
 * @package P4\BilletBundle\Controller
 * @Route("/order", name="order_prepare")
 */
class OrderController extends Controller
{
     /**
     * @Route(
     *     "/checkout",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
     public function checkoutAction()
     {
         \Stripe\Stripe::setApiKey("sk_test_z7elrU32ShOzh6FHzxbr3VUK");
 
         // Get the credit card details submitted by the form
         $token = $_POST['stripeToken'];
         $somme = $_POST['somme'];
 
         // Create a charge: this will charge the user's card
         try {
             $charge = \Stripe\Charge::create(array(
                 "amount" => $somme, // Amount in cents
                 "currency" => "eur",
                 "source" => $token,
                 "description" => "Paiement Musée du Louvre"
             ));
             return $this->redirectToRoute("homepage");
         } catch(\Stripe\Error\Card $e) {
 
             return $this->redirectToRoute("homepage");
         }
     }
}