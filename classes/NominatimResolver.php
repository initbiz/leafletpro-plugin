<?php namespace Initbiz\LeafletPro\Classes;

use maxh\Nominatim\Nominatim;
use Initbiz\LeafletPro\Models\Settings;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;
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

    public function resolv(AddressObjectInterface $addressObj)
    {
        $search = $this->prepareSearch($addressObj);
        
        $result = $this->nominatim->find($search);

        return $result;
    }

    protected function prepareSearch(AddressObjectInterface $addressObj)
    {
        $search = $this->nominatim->newSearch();

        $country = $addressObj->getCountry();
        if (!empty($country)) {
            $search = $search->country($country);
        }

        $postalCode = $addressObj->getPostalCode();
        if (!empty($postalCode)) {
            $search = $search->postalCode($postalCode);
        }

        $search = $search
                ->city($addressObj->getCity())
                ->street($addressObj->getStreet())
                ->polygon($this->polygon)
                ->addressDetails();

        return $search;
    }
}
