<?php

namespace Initbiz\LeafletPro\Components;

use Initbiz\LeafletPro\Models\Marker;
use Initbiz\LeafletPro\Components\LeafletMapBase;

class SingleMarkerMap extends LeafletMapBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.single_marker_map.name',
            'description' => 'initbiz.leafletpro::lang.components.single_marker_map.description'
        ];
    }

    public function defineProperties()
    {
        return $this->leafletProperties() + [
            'marker' => [
                'title'             => 'initbiz.leafletpro::lang.components.single_marker_map.marker_title',
                'description'       => 'initbiz.leafletpro::lang.components.single_marker_map.marker_description',
                'default'           => 'true',
                'type'              => 'dropdown',
            ],
            'findBy' => [
                'title'             => 'initbiz.leafletpro::lang.components.single_marker_map.find_by_title',
                'description'       => 'initbiz.leafletpro::lang.components.single_marker_map.find_by_description',
                'type'              => 'dropdown',
                'default'           => 'id',
                'options'           => [
                    'id'   => 'initbiz.leafletpro::lang.components.single_marker_map.find_by_id',
                    'name' => 'initbiz.leafletpro::lang.components.single_marker_map.find_by_name',
                ],
            ]
        ];
    }

    public function getMarkerOptions()
    {
        return Marker::published()->get()->pluck('name', 'id')->toArray();
    }

    public function makeMarkers()
    {
        $marker = Marker::where($this->property('findBy'), $this->property('marker'))->first();

        $markers = collect($marker);

        return $markers;
    }

    public function makeInitialCenterLatLon()
    {
        if (!$this->getOverriding && !empty($this->markers)) {
            $centerLatLon = $this->markers->first()->getLatLon();
        }

        return $centerLatLon;
    }

}
