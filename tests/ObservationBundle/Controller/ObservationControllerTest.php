<?php


namespace ObservationBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ObservationControllerTest extends WebTestCase
{
    public function testAddObservation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('observation_add'));

        $crawler = $client->followRedirect();
        // On verifie etre rediriger sur connection
        $this->assertEquals('ObservationBundle\Controller\UserController::connectAction', $client->getRequest()->attributes->get('_controller'));

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'phil';
        $form['_password'] = 'test';

        $crawler = $client->submit($form);


        $crawler = $client->followRedirect();
        $this->assertEquals('ObservationBundle\Controller\ObservationController::addAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


        $form = $crawler->selectButton('Valider la saisie')->form();

        $form['add_observation[location][longitude]'] = 42.025;
        $form['add_observation[location][latitude]'] = 5.25;
        $form['add_observation[location][lieu]'] = 'Lyon, Rhône France';
        $form['add_observation[seeAt]'] = '25/08/2001';
        $form['add_observation[bird]'] = 3;
        $form['add_observation[quantity]'] = 3;
        $form['add_observation[observation]'] = ' 3petits canards se promenaient';

        $crawler = $client->submit($form);

        $this->assertNotContains('help-block', $client->getResponse()->getContent());

    }
}