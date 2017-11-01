<?php

namespace P4\BilletBundle\Calculs;

class P4Calculs 
{
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