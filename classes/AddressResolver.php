<?php namespace Initbiz\LeafletPro\Classes;

use Lang;
use Validator;
use October\Rain\Exception\ValidationException;
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
     * @return array
     */
    public function resolv(AddressObjectInterface $addressObj)
    {
        self::validate($addressObj);

        return $this->resolver->resolv($addressObj);
    }

    public static function validate(AddressObjectInterface $addressObj)
    {
        $rules = [
            'street' => 'required',
            'city' => 'required',
        ];

        $validator = Validator::make($addressObj->toArray(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
