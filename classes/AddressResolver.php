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
        self::validate($addressObj);

        $response = $this->resolver->resolv($addressObj);

        if (empty($response)) {
            throw new EmptyResponse(Lang::get('initbiz.leafletpro::lang.exceptions.address_resolver_empty_response'));
        }

        return $response;
    }

    /**
     * Validates if address object has correct data
     * @param  AddressObjectInterface $addressObj
     * @return bool true when validation passes
     * @throws ValidationException when address object does not pass the validation
     */
    public static function validate(AddressObjectInterface $addressObj)
    {
        $rules = [
            'postal_code' => 'alpha_dash',
            'city' => 'alpha_num',
            'country' => 'alpha_num',
        ];

        $validator = Validator::make($addressObj->toArray(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
