<?php 

namespace P4\BilletBundle\Tests\Forms;

use Symfony\Component\Validator\Constraints\DateTime;
use P4\BilletBundle\Forms\P4Forms;
use PHPUnit\Framework\TestCase;

class P4FormsTest extends TestCase
{
    // Test du calcul de l'age
    public function testAge()
    {   
        $age = new P4Forms();
        $result = $age->age(\date_create('1997-06-05'), \date_create('2017-12-12'));

        $this->assertEquals(20, $result);
    }

    // Test du calcul deu prix de 3 billets differents
    public function testPrix()
    {   
        $age = new P4Forms();
        $result1 = $age->prix(65); //Tarif Senior
        $result2 = $age->prix(20); //Tarif Normal
        $result3 = $age->prix(8); //Tarif Enfant

        $result = $result1 + $result2 + $result3;

        // La somme des 3 billets doit faire 36€
        $this->assertEquals(36, $result);
    }
}