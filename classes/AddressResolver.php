<?php namespace Initbiz\LeafletPro\Classes;

use Lang;
use Validator;
use October\Rain\Exception\ValidationException;
use Initbiz\LeafletPro\Exceptions\EmptyResponse;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

/**
 * Class to resolve longitude and latitude from address
 */
class AddressResolver
{
    /**
     * Address resolver object
     * @var AddressResolverInterface
     */
    public $resolver;

    public function __construct(AddressResolverInterface $resolver = null)
    {
        if (!$resolver) {
            $resolver = new NominatimResolver();
        }

        $this->resolver = $resolver;
    }

    /**
     * Resolv longitude and latitude from address
     * @param  AddressObjectInterface $addressObj Object that stores address (country, city, street)
     * @return array of resolved addresses with lon and lan params
     */
    public function resolv(AddressObjectInterface $addressObj)
    {
        $response = $this->resolver->resolv($addressObj);

        if (empty($response)) {
            throw new EmptyResponse(Lang::get('initbiz.leafletpro::lang.exceptions.address_resolver_empty_response'));
        }

        return $response;
    }
}
