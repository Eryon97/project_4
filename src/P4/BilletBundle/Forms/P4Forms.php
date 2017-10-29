<?php

namespace P4\BilletBundle\Forms;

class P4Forms
{
    public function billets($formulaire)
    {
        $somme = 0;
        $date = $formulaire->getDate();
        $billets = $formulaire->getBillets();
        $mail = $formulaire->getEmail();
        foreach ($billets as $billet) {
            $naissance = $billet->getNaissance();
            $age = $this->age($naissance, $date);
            $tarif = $billet->getTarif();
            if ($tarif == true) {
                $prix = 10;
            } elseif ($tarif == false ) {
                $prix = $this->prix($age);
            }
            $nom = $billet->getNom();
            $prenom = $billet->getPrenom();
            $anniv = $billet->getNaissance();
            $cle = "MDL" . $date . $nom . $prenom . $anniv . "";
            $billet->setCle(sha1($cle));
            $somme = $somme + $prix;
            $billet->setPrix($prix);
        }
        $_SESSION['somme'] = ($somme * 100);
        $_SESSION['email'] = $mail;

        return $billets;
    }

    /** S'occupe du calcul de l'age en fonction des dates données 
    *
    * @param string $naissance $dateVisite
    * @return int 
    */

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

    /** S'occupe du calcul du prix en fonction de l'age
    *
    * @param int $age
    * @return int 
    */

    public function prix($age) {
        if ($age < 4 && $age >= 0) {
            $prix = 0;
        } else if ($age >= 4 && $age < 12) {
            $prix = 8;
        } else if ($age >=12 && $age < 60) {
            $prix = 16;
        } else if ($age >= 60) {
            $prix = 12;
        } else {}
        return $prix;
    }
}