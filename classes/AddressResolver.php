<?php namespace Initbiz\LeafletPro\Classes;

use Lang;
use Validator;
use October\Rain\Exception\ValidationException;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

/**
 * Class to resolve longitude and latitude of address
 */
class AddressResolver
{
    public $resolver;

    public function __construct(AddressResolverInterface $resolver = null)
    {
        if (!$resolver) {
            $resolver = new NominatimResolver();
        }

        $this->resolver = $resolver;
    }

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
