<?php namespace Initbiz\LeafletPro\Classes;

use Validator;
use October\Rain\Exception\ApplicationException;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;

class Address implements AddressObjectInterface
{
    protected $street = '';

    protected $postalCode = '';

    protected $city = '';
    
    protected $country = '';

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
    public function toArray()
    {
        return [
            'country' => $this->getCountry(),
            'city' => $this->getCity(),
            'postal_code' => $this->getPostalCode(),
            'street' => $this->getStreet(),
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
}
