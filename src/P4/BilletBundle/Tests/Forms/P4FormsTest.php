<?php

namespace P4\BilletBundle\Tests\Forms;

use Symfony\Component\Validator\Constraints\DateTime;
use P4\BilletBundle\Services\P4Forms;
use PHPUnit\Framework\TestCase;

class P4FormsTest extends TestCase
{

    // Test du calcul de l'age
    public function testAge()
    {
      $prixList = ['enfant' => 0, 'junior' => 8, 'adulte' => 16, 'senior' => 12];
        $age = new P4Forms($prixList);
        $result = $age->age(\date_create('1997-06-05'), \date_create('2017-12-12'));

        $this->assertEquals(20, $result);
    }

    // Test du calcul deu prix de 3 billets differents
    public function testPrix()
    {
        $prixList = ['enfant' => 0, 'junior' => 8, 'adulte' => 16, 'senior' => 12];
        $age = new P4Forms($prixList);
        $result1 = $age->prix(65); //Tarif Senior
        $result2 = $age->prix(20); //Tarif Normal
        $result3 = $age->prix(8); //Tarif Enfant


        $this->assertEquals(12, $result1);
        $this->assertEquals(16, $result2);
        $this->assertEquals(8, $result3);
    }

    // Test du formulaire via P4Forms


    // Test du calcul de prix total
    public function testTotal()
    {
      $prixList = ['enfant' => 0, 'junior' => 8, 'adulte' => 16, 'senior' => 12];

      $total = 0;
      $age = new P4Forms($prixList);

      $total = $total + $age->prix(60) + $age->prix(14) + $age->prix(2) + $age->prix(6);

      $this->assertEquals(36, $total);
    }
}
