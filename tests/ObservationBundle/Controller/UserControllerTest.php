<?php


namespace ObservationBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testInscription()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('user_connect'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('ObservationBundle\Controller\UserController::connectAction', $client->getRequest()->attributes->get('_controller'));

        // On véifie ne pas être connecter
        $this->assertContains('Connexion/Inscription', $client->getResponse()->getContent());

        $form = $crawler->selectButton('Inscription')->form();

        // Remplissage du formulaire avec username et email aléatoire
        $form['user[username]'] = uniqid();
        $form['user[email]'] = uniqid() . '@mail.com';
        $form['user[plainPassword][first]'] = 'test';
        $form['user[plainPassword][second]'] = 'test';
        $form['user[firstname]'] = 'test';
        $form['user[lastname]'] = 'test';
        $form['user[birthDate]'] = '25/08/1987';

        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals('ObservationBundle\Controller\DefaultController::indexAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertContains('Compte', $client->getResponse()->getContent());

    }
}