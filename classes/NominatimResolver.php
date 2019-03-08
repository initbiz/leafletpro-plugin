<?php namespace Initbiz\LeafletPro\Classes;

use maxh\Nominatim\Nominatim;
use Initbiz\LeafletPro\Models\Settings;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

class NominatimResolver implements AddressResolverInterface
{
    /**
     * Nominatim object from maxh/Nominatim
     * @var Nominatim
     */
    public $nominatim;

    /**
     * polygon type for Nominatim, either 'geojson', 'kml', 'svg' or 'text'
     * @var string
     */
    public $polygon;

    public function __construct()
    {
        $url = Settings::get('nominatim_url');

        if (empty($url)) {
            $url = "http://nominatim.openstreetmap.org/";
        }

        $this->nominatim = new Nominatim($url);

        $this->setPolygon();
    }

    /**
     * Sets polygon for Nominatim
     * @param string $polygon [description]
     */
    public function setPolygon(string $polygon='geojson')
    {
        $this->polygon = $polygon;
    }

    /**
     * {@inheritdoc}
     */
    public function resolv(AddressObjectInterface $addressObj): array
    {
        $search = $this->prepareSearch($addressObj);

        $result = $this->nominatim->find($search);

        return $result;
    }

    /**
     * Prepares search object for maxh/Nominatim
     * @param  AddressObjectInterface $addressObj object storing address
     * @return \maxh\Nominatim\Search             prepared search
     */
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
