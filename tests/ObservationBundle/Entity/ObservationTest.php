<?php

namespace Tests\ObservationBundle\Entity;

use ObservationBundle\Entity\Bird;
use ObservationBundle\Entity\Location;
use ObservationBundle\Entity\Observation;
use PHPUnit\Framework\TestCase;

class ObservationTest extends TestCase
{
    public function testDatePoste()
    {
        $observation = new Observation();
        $datePoste = new \DateTime('2014-02-12 14:02');
        $observation->setPostedAt($datePoste);
        $this->assertEquals('14:02:12', $observation->getPostedAt());
    }

    public function testDateSee()
    {
        $observation = new Observation();
        $datePoste = new \DateTime('2014-02-12 14:02');
        $observation->setPostedAt($datePoste);
        $datePoste = new \DateTime('2013-01-22 02:02');
        $observation->setSeeAt($datePoste);

        $this->assertEquals('2013-01-22 02:02', $observation->getSeeAt()->format('Y-m-d H:i'));
    }

    public function testBird()
    {
        $observation = new Observation();
        $datePoste = new \DateTime('2014-02-12 14:02');
        $observation->setPostedAt($datePoste);
        $datePoste = new \DateTime('2013-01-22 02:02');
        $observation->setSeeAt($datePoste);
        $bird = new Bird();
        $bird->setNomVern('canard');
        $observation->setBird($bird);

        $this->assertEquals('canard', $observation->getBird()->getNomVern());
    }

    public function testDescription()
    {
        $observation = new Observation();
        $datePoste = new \DateTime('2014-02-12 14:02');
        $observation->setPostedAt($datePoste);
        $datePoste = new \DateTime('2013-01-22 02:02');
        $observation->setSeeAt($datePoste);
        $bird = new Bird();
        $bird->setNomVern('canard');
        $observation->setBird($bird);
        $observation->setObservation("J'ai vu 3 canards lors de ma promenade familliale qui mangeaient du poisson.");

        $this->assertEquals("J'ai vu 3 canards lors de ma promenade familliale qui mangeaient du poisson.", $observation->getObservation());
    }
    public function testLocation()
    {
        $observation = new Observation();
        $datePoste = new \DateTime('2014-02-12 14:02');
        $observation->setPostedAt($datePoste);
        $datePoste = new \DateTime('2013-01-22 02:02');
        $observation->setSeeAt($datePoste);
        $bird = new Bird();
        $bird->setNomVern('canard');
        $observation->setBird($bird);
        $observation->setObservation("J'ai vu 3 canards lors de ma promenade familliale qui mangeaient du poisson.");
        $location = new Location();
        $location->setLatitude(42.0335)
            ->setLongitude(5.6489514)
            ->setLieu('Lyon, Rhône France');

        $this->assertNull($observation->getLocation());
        $observation->setLocation($location);

        $this->assertEquals("Lyon, Rhône France", $observation->getLocation()->getLieu());
        $this->assertNotEquals("Lyon, Rhône France", $observation->getLocation()->getLatitude());
        $this->assertEquals(42.0335, $observation->getLocation()->getLatitude());
        $this->assertEquals(5.6489514, $observation->getLocation()->getLongitude());

    }

}