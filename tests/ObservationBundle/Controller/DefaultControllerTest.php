<?php

namespace ObservationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('ObservationBundle\Controller\DefaultController::indexAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertContains('Bienvenue', $client->getResponse()->getContent());
    }

    public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('contact_message'));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains('Envoyer', $client->getResponse()->getContent());

        // Séléction du formulaire de contact
        $form = $crawler->selectButton('Envoyer')->form();

        // Remplisage du formulaire
        $form['message[email]'] = 'test@mail.com';
        $form['message[title]'] = 'super site';
        $form['message[message]'] = "J'adore votre site. Il est super, continuer comme ca.";

        // Envoie du mail
        $client->request($form->getMethod(), $form->getUri());
        $this->assertEquals('ObservationBundle\Controller\DefaultController::contactAction', $client->getRequest()->attributes->get('_controller'));

     }
}
