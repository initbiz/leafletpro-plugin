<?php namespace Initbiz\LeafletPro\Contracts;

/**
 * Address object contract
 */
interface AddressObjectInterface
{
    /**
     * Get string from object
     * @return string
     */
    public function getStreet();

    /**
     * Get postal code from object
     * @return string
     */
    public function getPostalCode();

    /**
     * Get city from object
     * @return string
     */
    public function getCity();

    /**
     * Get country from object
     * @return string
     */
    public function getCountry();

    public function toArray();
}
