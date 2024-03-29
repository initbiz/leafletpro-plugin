<?php

namespace Initbiz\Leafletpro\Models;

use Model;

/**
 * Group Model
 */
class Group extends Model
{
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Purgeable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'initbiz_leafletpro_groups';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required'
    ];

    protected $slugs = [
        'slug' => 'name',
    ];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $hasMany = [
        'markers' => \Initbiz\LeafletPro\Models\Marker::class
    ];

    protected $purgeable = ['marker_icon_url', 'marker_icon_media'];

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
    public function getIconUrlAttribute()
    {
        $markerIcon = null;
        if ($this->marker_icon) {
            if ($this->marker_icon_from === 'url') {
                $markerIcon = $this->marker_icon;
            } elseif ($this->marker_icon_from === 'media') {
                if (class_exists('System')) {
                    $markerIcon = \Media\Classes\MediaLibrary::url($this->marker_icon);
                } else {
                    $markerIcon = \System\Classes\MediaLibrary::url($this->marker_icon);
                }
            }
        }

        return $markerIcon;
    }
}
