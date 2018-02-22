<?php

namespace P4\BilletBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Validator\Constraints\DateTime;

class DefaultControllerTest extends WebTestCase
{
    //Test de la creation de la page index
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/');

        // simuler avec 1  ou plusieurs billets dans le formulaire
        //verifier pas d'erreur 500
        $this->assertEquals(5, $crawler->filter('div.form-group')->count());
    }

    //Test nombre de billet affiché en fonction du nombre demandé
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/');

        $form = $crawler->selectButton('Continuer')->form();

        $form['start_form[date]']->setValue((new \DateTime('1997-06-05'))->format('Y-m-d'));
        $form['start_form[nombre]']->select(3);
        $form['start_form[email]']->setValue('lucas57905@gmail.com');
        $form['start_form[type]']->setValue('journee');

        //     'start_form[date]' => (new \DateTime('1997-06-05'))->format('Y-m-d'),
        //     'start_form[nombre]' => 3,
        //     'start_form[email]' => 'lucas57905@gmail.com',
        //     'start_form[type]' => 'journee'
        // ));

        $crawler = $client->submit($form);


        $this->assertEquals(3, $form['start_form[nombre]']->getValue());

    }
}
