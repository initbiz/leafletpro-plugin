<?php namespace Initbiz\LeafletPro\Models;

use Lang;
use Model;
use RainLab\Location\Models\Country;
use Initbiz\LeafletPro\Classes\AddressResolver;
use October\Rain\Exception\ApplicationException;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;

/**
 * Marker Model
 */
class Marker extends Model implements AddressObjectInterface
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'initbiz_leafletpro_markers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'country' => [
            Country::class,
            'table' => 'rainlab_location_countries',
        ]
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function refreshLongLat()
    {
        $addressResolver = new AddressResolver();

        $response = $addressResolver->resolv($this);

        if (empty($response)) {
            throw new ApplicationException(Lang::get('initbiz.leafletpro::lang.exceptions.address_resolver_empty_response'));
        }

        //TODO: to consider pop up with other possibilities, right now getting first element
        $address = $response[0];

        $this->lat = $address['lat'];
        $this->long = $address['lon'];
    }

    public function getLongLat()
    {
        return [
            'long' => $this->long,
            'lat' => $this->lat,
        ];
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country()->first()->name;
    }
}
