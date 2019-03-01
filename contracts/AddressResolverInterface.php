<?php namespace Initbiz\LeafletPro\Contracts;

/**
 * Address resolver contract
 */
interface AddressResolverInterface
{
    public function resolv(string $thoroughfare, string $city, string $country = '');
}
