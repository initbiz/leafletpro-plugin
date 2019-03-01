<?php namespace Initbiz\LeafletPro\Models;

use Model;
use RainLab\Location\Models\Country;

/**
 * Marker Model
 */
class Marker extends Model
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
}
