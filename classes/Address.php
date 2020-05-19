<?php namespace Initbiz\LeafletPro\Classes;

use Initbiz\LeafletPro\Contracts\AddressObjectInterface;

class Address implements AddressObjectInterface
{
    public $street = '';

    public $postalCode = '';

    public $city = '';

    public $country = '';

    public $lon = '';

    public $lat = '';

    /**
     * When resolver cannot resolve the address we can set this to true
     *
     * @var boolean
     */
    public $irresolvable = false;

    /**
     * {@inheritdoc}
     */
    public function getStreet(): string
    {
        return $this->street ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getPostalCode(): string
    {
        return $this->postalCode ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getCity(): string
    {
        return $this->city ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry(): string
    {
        return $this->country ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getLon(): string
    {
        return $this->lon ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getLat(): string
    {
        return $this->lat ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getLatLon(): ?string
    {
        $lat = $this->getLat();
        $lon = $this->getLon();

        if (!empty($lat) && !empty($lon)) {
            return $lat . ', ' . $lon;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'country' => $this->getCountry(),
            'city' => $this->getCity(),
            'postal_code' => $this->getPostalCode(),
            'street' => $this->getStreet(),
            'lon' => $this->getLon(),
            'lat' => $this->getLat(),
        ];
    }

    /**
     * Set object properties from array like:
     * [
     *      'country'   => 'Poland',
     *      'city'      => 'Warsaw',
     * ]
     *
     * @param array $data
     * @return void
     */
    public function setFromArray(array $data)
    {
        $this->setCountry($data['country'] ?? '');
        $this->setCity($data['city'] ?? '');
        $this->setPostalCode($data['postalCode'] ?? '');
        $this->setStreet($data['street'] ?? '');
        $this->setLon($data['lon'] ?? '');
        $this->setLat($data['lat'] ?? '');
    }

    /**
     * Set the value of street
     *
     * @return  self
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Set the value of postalCode
     *
     * @return  self
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Set the value of lon
     *
     * @return  self
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    /**
     * Set the value of lat
     *
     * @return  self
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Shortcut to create object of the Address class using array with params
     *
     * @param array $addressArray
     * @return Address
     */
    public static function ofArray(array $addressArray): Address
    {
        $address = new Address();
        $address->setFromArray($addressArray);
        return $address;
    }

}
