<?php namespace Initbiz\LeafletPro\Models;

use Lang;
use Model;
use Cms\Classes\Theme;
use RainLab\Location\Models\Country;
use Initbiz\CumulusCore\Models\Cluster;
use Initbiz\LeafletPro\Classes\AddressResolver;
use October\Rain\Exception\ApplicationException;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;

/**
 * Marker Model
 */
class Marker extends Model implements AddressObjectInterface
{
    use \October\Rain\Database\Traits\Nullable;
    use \System\Traits\ViewMaker;

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
     * @var array Nullable fields
     */
    protected $nullable = ['cluster_id', 'country_id'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'country' => [
            Country::class,
            'table' => 'rainlab_location_countries',
        ]
    ];

    public function filterFields($fields, $context = null)
    {
        // When Cluster selected automatically set the marker's params based on the cluster's ones
        if (isset($fields->cluster_id) && $fields->cluster_id->value !== null) {
            $cluster = Cluster::find($fields->cluster_id->value);

            if (empty($fields->name->value)) {
                $fields->name->value = $cluster->name;
            }

            if (empty($fields->street->value)) {
                $fields->street->value = $cluster->thoroughfare;
            }

            if (empty($fields->postal_code->value)) {
                $fields->postal_code->value = $cluster->postal_code;
            }

            if (empty($fields->city->value)) {
                $fields->city->value = $cluster->city;
            }

            if (empty($fields->country_id->value)) {
                if ($cluster->country()->first()) {
                    $countryId = $cluster->country()->first()->id;
                    $fields->country_id->value = $countryId;
                }
            }
        }
    }

    public function afterSave()
    {
        // When popup content empty after save than seed it with contents of _default_popup_content partial
        if (empty($this->popup_content)) {
            $this->addViewPath($this->guessViewPath());
            $this->addViewPath(Theme::getActiveTheme()->getPath().'/partials');
            $this->popup_content = $this->makePartial('default_popup_content', ['model' => $this]);
            $this->save();
        }
    }

    public function getCountryIdOptions()
    {
        return Country::all()->pluck('name', 'id')->toArray();
    }

    /**
     * Get only published markers
     * @param  QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Refresh this object's longitude and latitude attributes using address resolver and address specified in this object
     * @return void
     */
    public function refreshLonLat()
    {
        $addressResolver = new AddressResolver();

        $response = $addressResolver->resolv($this);

        $address = $response[0];

        $this->lat = $address['lat'];
        $this->lon = $address['lon'];
    }

    /**
     * Get array of this models lon and lat params
     * @return array longitude and latitude of this marker
     */
    public function getLonLat(): array
    {
        return [
            'lon' => $this->lon,
            'lat' => $this->lat,
        ];
    }

    // Methods from Address Object interface

    /**
     * {@inheritdoc}
     */
    public function getStreet(): string
    {
        return $this->street ?? "";
    }

    /**
     * {@inheritdoc}
     */
    public function getPostalCode(): string
    {
        return $this->postal_code ?? "";
    }

    /**
     * {@inheritdoc}
     */
    public function getCity(): string
    {
        return $this->city ?? "";
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry(): string
    {
        //Use relation or country_id attribute if relation does not exist yet
        if ($this->country()->first()) {
            return $this->country()->first()->name;
        }
        if (!empty($this->country_id)) {
            return Country::find($this->country_id)::first()->name;
        }

        return "";
    }
}
