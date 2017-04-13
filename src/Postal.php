<?php
namespace nuicart\Dutchgeo;

use nuicart\Dutchgeo\Exception\NotFoundException;

/**
 * Class Postal
 * @package nuicart\Dutchgeo
 */
class Postal
{
    /**
     * @param $sPostal - A dutch postalcode
     * @return LatLong - A simple object with latutude and longitude getter
     * @throws \InvalidArgumentException - When the specified postal code does not meet the criteria for a Dutch postal code ^[0-9]{4}[A-Z]{2}$
     * @throws ApiException - When the Google API responds with something we don't understand.
     * @throws NotFoundException - When the postal is not found or does not exist.
     */
    static function getLatLong($sPostal)
    {
        $sPostal = strtoupper($sPostal);
        $sPostal = preg_replace('/\s+/', '', $sPostal);

        if (!preg_match('/^[0-9]{4}[A-Z]{2}$/', $sPostal))
        {
            throw new \InvalidArgumentException("Postalcode format needs to be four digits followed by to characters, got $sPostal.", 1);
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
                throw new ApiException("Curl connection timed out when doing a Geodecode request at the Google maps API, should we slow down a bit?");
            }
            throw new ApiException("Got an unexpected response from the Google API when doing a GeoDecode for postal $sPostal.");
        }

        $aJson = json_decode($sJson, true);

        if(!isset($aJson['results']) || !isset($aJson['results'][0]) || !isset($aJson['results'][0]['geometry']) || !isset($aJson['results'][0]['geometry']['location']))
        {
            throw new NotFoundException("The lat long for the specified postal was not found.");
        }

        $aLatLong = $aJson['results'][0]['geometry']['location'];
        $oLatLong = new LatLong($aLatLong['lat'], $aLatLong['lng']);
        return $oLatLong;
    }
}
