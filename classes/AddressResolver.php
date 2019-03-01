<?php namespace Initbiz\LeafletPro\Classes;

use Lang;
use Validator;
use October\Rain\Exception\ValidationException;
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

    public function resolv(string $thoroughfare, string $city, string $country = '')
    {
        $data = [
            'thoroughfare' => $thoroughfare,
            'city' => $city,
            'country' => $country,
        ];

        self::validate($data);

        return $this->resolver->resolv($thoroughfare, $city, $country);
    }

    public static function validate(array $addressData)
    {
        $rules = [
            'thoroughfare' => 'required',
            'city' => 'required',
        ];

        $validator = Validator::make($addressData, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages);
        }
    }
}
