<?php


namespace Tests\ObservationBundle\Entity;


use ObservationBundle\Entity\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testLatitude()
    {
        $location = new Location();

        $this->assertNull($location->getLatitude());
        $location->setLatitude(42.033);

        $this->assertNotEquals(022, $location->getLatitude());
        $this->assertEquals(42.033, $location->getLatitude());
    }

    public function testLongitude()
    {
        $location = new Location();
        $location->setLatitude(42.033);
        $this->assertNull($location->getLongitude());
        $location->setLongitude(5.01);
        $this->assertNotEquals(022, $location->getLongitude());
        $this->assertEquals(5.01, $location->getLongitude());
    }

    public function testLieu()
    {
        $location = new Location();
        $location->setLatitude(42.033);
        $location->setLongitude(5.01);
        $this->assertNull($location->getLieu());
        $location->setLieu('Lyon, Rhône France');
        $this->assertNotEquals(022, $location->getLieu());
        $this->assertEquals('Lyon, Rhône France', $location->getLieu());
    }

}