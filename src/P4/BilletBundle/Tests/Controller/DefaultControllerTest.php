<?php

namespace P4\BilletBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    //Test de la creation de la page index
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/');
    
        //La page d'index doit comporter 5 form-group, qui correspont aux 5 champs du premier formulaire
        $this->assertEquals(5, $crawler->filter('div.form-group')->count());
    }
}
