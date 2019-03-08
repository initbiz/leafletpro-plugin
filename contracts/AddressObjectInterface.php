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
    public function getStreet(): string;

    /**
     * Get postal code from object
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * Get city from object
     * @return string
     */
    public function getCity(): string;

    /**
     * Get country from object
     * @return string
     */
    public function getCountry(): string;

    /**
     * Get array of the data
     * @return array array like ['street' => 'foo', 'city' => 'bar'] etc.
     */
    public function toArray();
}
