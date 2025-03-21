<?php

namespace Initbiz\LeafletPro\Classes;

use GuzzleHttp\Client;
use Initbiz\LeafletPro\Models\Settings;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

class NominatimResolver implements AddressResolverInterface
{
    public $client;

    /**
     * polygon type for Nominatim, either 'geojson', 'kml', 'svg' or 'text'
     * @var string
     */
    public $polygon;

    public function __construct()
    {
        $url = Settings::get('nominatim_url');

        if (empty($url)) {
            $url = "https://nominatim.openstreetmap.org/";
        }

        $this->client = new Client(['base_uri' => $url]);

        $this->setPolygon();
    }

    /**
     * Sets polygon for Nominatim
     * @param string $polygon [description]
     */
    public function setPolygon(string $polygon = 'geojson')
    {
        $this->polygon = $polygon;
    }

    /**
     * {@inheritdoc}
     */
    public function resolv(AddressObjectInterface $addressObj): array
    {
        $uri = '/search?';
        $uri .= http_build_query([
            'format' => 'json',
            'country' => $addressObj->getCountry(),
            'postalcode' => $addressObj->getPostalCode(),
            'city' => $addressObj->getCity(),
            'street' => $addressObj->getStreet(),
            'polygon_geojson' => '1',
            'addressdetails' => '1',
        ]);
        try {
            $response = $this->client->request('GET', $uri, ['headers' => ['User-Agent' => 'leaflet_pro']]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
