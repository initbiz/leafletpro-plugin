<?php

namespace Initbiz\LeafletPro\Models;

use Model;
use Cms\Classes\Theme;
use RainLab\Location\Models\Country;
use Initbiz\CumulusCore\Models\Cluster;
use Initbiz\LeafletPro\Classes\AddressResolver;
use Initbiz\LeafletPro\Contracts\AddressObjectInterface;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

/**
 * Marker Model
 */
class Marker extends Model implements AddressObjectInterface
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Purgeable;
    use \October\Rain\Database\Traits\Nullable;
    use \System\Traits\ViewMaker;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'initbiz_leafletpro_markers';

    public $rules = [
        'name' => 'required',
        'lat' => 'required|numeric',
        'lon' => 'required|numeric'
    ];
    
    /**
    * @var translatable marker fields
    */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    
    public $translatable = [
        'name',
        'popup_content'
    ];

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

    protected $purgeable = ['marker_icon_url', 'marker_icon_media'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'country' => [
            Country::class,
            'table' => 'rainlab_location_countries',
        ],
        'group' => [
            Group::class
        ],
    ];

    public function filterFields($fields, $context = null)
    {
        // When Cluster selected automatically set the marker's params based on the cluster's ones
        if (isset($fields->cluster_id) && !empty($fields->cluster_id->value)) {

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

    public function beforeSave()
    {
        $markerIcon = null;
        if ($this->marker_icon_from === 'url') {
            $markerIcon = $this->getOriginalPurgeValue('marker_icon_url');
        } elseif ($this->marker_icon_from === 'media') {
            $markerIcon = $this->getOriginalPurgeValue('marker_icon_media');
        }
        $this->marker_icon = $markerIcon;
    }

    public function afterSave()
    {
        // When popup content empty after save than seed it with contents of _default_popup_content partial
        if (empty($this->popup_content)) {
            $this->addViewPath($this->guessViewPath());
            $this->addViewPath(Theme::getActiveTheme()->getPath() . '/partials');
            $this->popup_content = $this->makePartial('default_popup_content', ['model' => $this]);
            $this->save();
        }
    }

    public function getCountryIdOptions()
    {
        return Country::getNameList();
    }

    public function getMarkerIconUrlAttribute()
    {
        if ($this->marker_icon_from === 'url') {
            return $this->marker_icon;
        }
    }

    public function getMarkerIconMediaAttribute()
    {
        if ($this->marker_icon_from === 'media') {
            return $this->marker_icon;
        }
    }

    public function getIconUrlAttribute(): ?string
    {
        $markerIcon = null;
        if (!empty($this->marker_icon)) {
            if ($this->marker_icon_from === 'url') {
                $markerIcon = $this->marker_icon;
            } elseif ($this->marker_icon_from === 'media') {
                if (class_exists('System')) {
                    $markerIcon = \Media\Classes\MediaLibrary::url($this->marker_icon);
                } else {
                    $markerIcon = \System\Classes\MediaLibrary::url($this->marker_icon);
                }
            }
        } elseif ($this->group && $this->group->iconUrl) {
            $markerIcon = $this->group->iconUrl;
        }

        return $markerIcon;
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
     * Refresh this object's longitude and latitude attributes using address
     * resolver and address specified in this object
     * @return void
     */
    public function refreshLatLon(AddressResolverInterface $addressResolver = null)
    {
        if (is_null($addressResolver)) {
            $addressResolver = new AddressResolver();
        }

        $response = $addressResolver->resolv($this);

        $address = $response[0];

        $this->lat = $address['lat'];
        $this->lon = $address['lon'];
    }

    /**
     * Get array of this models lon and lat params
     * @return array longitude and latitude of this marker
     */
    public function getLatLonArray(): array
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

    /**
     * {@inheritdoc}
     */
    public function getLat(): string
    {
        return $this->lat ?? "";
    }

    /**
     * {@inheritdoc}
     */
    public function getLon(): string
    {
        return $this->lon ?? "";
    }

    /**
     * {@inheritdoc}
     */
    public function getLatLon(string $delimiter = ' '): string
    {
        $lat = $this->getLat();
        $lon = $this->getLon();

        if (!empty($lat) && !empty($lon)) {
            return $lat . $delimiter . $lon;
        }
    }
}
