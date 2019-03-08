<?php namespace Initbiz\LeafletPro\Contracts;

/**
 * Address resolver contract
 */
interface AddressResolverInterface
{
    /**
     * Get longitude and latitude params using address
     * @param  AddressObjectInterface $addressObj object storing address
     * @return array                              array of resolved addresses with lon and lan params
     */
    public function resolv(AddressObjectInterface $addressObj): array;
}
