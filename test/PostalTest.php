<?php
namespace nuicart\Dutchgeo;

use nuicart\Dutchgeo\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

class PostalTest extends TestCase
{
    function testPostalVersion1()
    {
        $oLatLong = Postal::getLatLong('1421AW');
        $this->assertInstanceOf('nuicart\\Dutchgeo\\LatLong', $oLatLong);
    }
    function testPostalVersion2()
    {
        $oLatLong = Postal::getLatLong('1421 AW');
        $this->assertInstanceOf('nuicart\\Dutchgeo\\LatLong', $oLatLong);
    }
    function testNonExistentPostal()
    {
        // Postalcodes ending with SS are not allowed
        try{
            Postal::getLatLong('0005SS');
            // No exception was thrown
            $this->assertTrue(false);
        }
        catch (NotFoundException $e)
        {
            $this->assertTrue(true);
        }
    }
    function testInvalidPostal()
    {
        // Postalcodes ending with SS are not allowed
        try{
            Postal::getLatLong('DDDD33');
            // No exception was thrown
            $this->assertTrue(false);
        }
        catch (\InvalidArgumentException $e)
        {
            $this->assertTrue(true);
        }
    }
}
