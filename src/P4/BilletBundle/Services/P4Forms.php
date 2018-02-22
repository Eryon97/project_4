<?php

namespace P4\BilletBundle\Services;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Date;

class P4Forms
{
    private $prixList = array();

    public function __construct(array $prixList) {
        $this->prixList = $prixList;
    }

    public function billets($formulaire, $prixList)
    {
        $somme = 0;
        $date = $formulaire->getDate();
        if ( $date->format('h') >= 14 && $date->format('dmY') === (new \DateTime())->format('dmY'))
        {
            $formulaire->setType("demi_journee");
        }
        $billets = $formulaire->getBillets();
        $mail = $formulaire->getEmail();
        foreach ($billets as $billet) {
            $naissance = $billet->getNaissance();
            $age = $this->age($naissance, $date);
            $tarif = $billet->getTarif();
            if ($tarif == true) {
                $prix = 10;
            } elseif ($tarif == false ) {
                $prix = $this->prix($age, $prixList);
            }
            $nom = $billet->getNom();
            $prenom = $billet->getPrenom();
            $anniv = $billet->getNaissance();
            $cle = "MDL" . $date->format('dmY') . $nom . $prenom . $anniv->format('dmY') . "";
            $billet->setCle(password_hash($cle, PASSWORD_DEFAULT));
            $somme = $somme + $prix;
            $billet->setPrix($prix);
            $billet->setDate($date);
        }
        $_SESSION['somme'] = ($somme * 100);

        return $billets;
    }

    /** S'occupe du calcul de l'age en fonction des dates données
    *
    * @param string $naissance $dateVisite
    * @return int
    */

    public function age( \DateTime $naissance, \DateTime $dateVisite) {
        return $dateVisite->diff($naissance)->y;
    }

    /** S'occupe du calcul du prix en fonction de l'age
    *
    * @param int $age
    * @return int
    */

    public function prix($age) {
        if ($age < 4 && $age >= 0) {
            $prix = $this->prixList['enfant'];
        } else if ($age >= 4 && $age < 12) {
            $prix = $this->prixList['junior'];
        } else if ($age >=12 && $age < 60) {
            $prix = $this->prixList['adulte'];
        } else if ($age >= 60) {
            $prix = $this->prixList['senior'];
        } else {}
        return $prix;
    }
}
