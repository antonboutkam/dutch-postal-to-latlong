<?php
namespace DutchGeo\Decode;

class Postal
{
    static function getLatLong($sPostal)
    {
        $sPostal = strtoupper($sPostal);
        $sPostal = preg_replace('/\s+/', '', $sPostal);

        if (!preg_match('/^[0-9]{4}[A-Z]{2}$/', $sPostal))
        {
            throw new Exception("Postalcode format needs to be four digits followed by to characters, got $sPostal.", 1);
        }

        $sAddress = urlencode("$sPostal, Nederland");
        $sUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=$sAddress";

        $rCurl = curl_init();
        $iTimeout = 5;
        curl_setopt($rCurl, CURLOPT_URL, $sUrl);
        curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rCurl, CURLOPT_CONNECTTIMEOUT, $iTimeout);

        $sJson = curl_exec($rCurl);
        curl_close($rCurl);

        if(!strpos($sJson, '{') === 0)
        {
            if(curl_errno($rCurl))
            {
                throw new LogicException("Curl connection timed out when doing a Geodecode request at the Google maps API, should we slow down a bit?", 2);
            }
            throw new LogicException("Got an unexpected response from the Google API when doing a GeoDecode for postal $sPostal.", 3);
        }

        $aJson = json_decode($sJson, true);

        return $aJson['geometry']['location'];
    }
}

try
{
    $aLatLong - GeoCode::getLatLongFromPostal('1421 AW');
}
catch (Exception $e)
{
    if($e->getCode() == 1)
    {
        // Notify someone to fix the postal or do nothing, log a record in the database so it can be fixed.
    }
    else if($e->getCode() == 2)
    {
        // Notify someone to fix the scripot/cronjob or do nothing, log a record in the database so it can be fixed.
    }
    else if($e->getCode() == 3)
    {
        // Notify someone to fix the scripot/cronjob or do nothing, log a record in the database so it can be fixed.
    }
}

