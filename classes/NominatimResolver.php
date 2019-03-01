<?php namespace Initbiz\LeafletPro\Classes;

use Initbiz\LeafletPro\Contracts\AddressResolver;
use maxh\Nominatim\Nominatim;


class NominatimResolver implements AddressResolverInterface
{
    public $nominatim;

    public $polygon; //'geojson', 'kml', 'svg' and 'text'

    public function __construct()
    {
        $url = "http://nominatim.openstreetmap.org/";

        $this->nominatim = new Nominatim($url);

        $this->setPolygon();
    }

    public function setPolygon(string $polygon='geojson')
    {
        $this->polygon = $polygon;
    }

    public function resolv(string $thoroughfare, string $city, string $country = '');
    {

        $search = $nominatim->newSearch();

        if ($country !== '') {
            $search = $search->country($country);
        }

        $search = $search
                ->city($city)
                ->street($thoroughfare)
                ->polygon($this->polygon)
                ->addressDetails();

        $result = $nominatim->find($search);
    }
}
