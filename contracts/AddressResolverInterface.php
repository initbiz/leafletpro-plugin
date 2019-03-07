<?php namespace Initbiz\LeafletPro\Contracts;

/**
 * Address resolver contract
 */
interface AddressResolverInterface
{
    public function resolv(AddressObjectInterface $addressObj);
}
