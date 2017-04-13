<?php
namespace nuicart\Dutchgeo;

class LatLong{

    private $iLat;
    private $iLong;

    function __construct($iLat, $iLong)
    {
        $this->iLat = $iLat;
        $this->iLong = $iLong;
    }
    function getLat()
    {
        return $this->iLat;
    }
    function getLong()
    {
        return $this->iLong;
    }
}