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
    }

    /**
     * {@inheritdoc}
     */
    public function getPostalCode(): string
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getCity(): string
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry(): string
    {
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
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
        $this->setCountry = $data['country'];
        $this->setCity = $data['city'];
        $this->setPostalCode = $data['postalCode'];
        $this->setStreet = $data['street'];
    }

    /**
     * Set the value of street
     *
     * @return  self
     */
    public function setStreet($street)
    {
        $validation = Validator::make(['street' => $street], ['street' => 'alpha_num']);

        if ($validation->fails()) {
            throw new ApplicationException("Bad format for street");
        }

        $this->street = $street;
    }

    /**
     * Set the value of postalCode
     *
     * @return  self
     */
    public function setPostalCode($postalCode)
    {
        $validation = Validator::make(['postal_code' => $postalCode], ['postal_code' => 'alpha_dash']);

        if ($validation->fails()) {
            throw new ApplicationException("Bad format for postal code");
        }

        $this->postalCode = $postalCode;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function setCity($city)
    {
        $validation = Validator::make(['city' => $city], ['city' => 'alpha_num']);

        if ($validation->fails()) {
            throw new ApplicationException("Bad format for city");
        }

        $this->city = $city;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */
    public function setCountry($country)
    {
        $validation = Validator::make(['country' => $country], ['country' => 'alpha_num']);

        if ($validation->fails()) {
            throw new ApplicationException("Bad format for country");
        }

        $this->country = $country;
    }
}
