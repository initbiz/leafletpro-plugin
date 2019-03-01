<?php namespace Initbiz\LeafletPro\Classes;

use maxh\Nominatim\Nominatim;
use Initbiz\LeafletPro\Models\Settings;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

class NominatimResolver implements AddressResolverInterface
{
    public $nominatim;

    public $polygon; //'geojson', 'kml', 'svg' and 'text'

    public function __construct()
    {
        $url = Settings::get('nominatim_url');

        if (empty($url)) {
            $url = "http://nominatim.openstreetmap.org/";
        }

        $this->nominatim = new Nominatim($url);

        $this->setPolygon();
    }

    public function setPolygon(string $polygon='geojson')
    {
        $this->polygon = $polygon;
    }

    public function resolv(string $thoroughfare, string $city, string $country = '')
    {
        $search = $this->nominatim->newSearch();

        if ($country !== '') {
            $search = $search->country($country);
        }

        $search = $search
                ->city($city)
                ->street($thoroughfare)
                ->polygon($this->polygon)
                ->addressDetails();

        $result = $this->nominatim->find($search);

        return $result;
    }
}
