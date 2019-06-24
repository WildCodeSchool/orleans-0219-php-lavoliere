<?php


namespace App\Service;

use App\Entity\Location;

class LocationService
{
    public function formatLocation(Location $location) : string
    {
        $name = $location->getName();
        $adress = $location->getAdress();
        $postalCode = $location->getPostalCode();
        $city = $location->getCity();

        $adressFormated = "$name. $adress, $postalCode $city";
        return $adressFormated;
    }
}
