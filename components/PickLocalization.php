<?php

declare(strict_types=1);

namespace Initbiz\LeafletPro\Components;

/**
 * PickLocalization Component
 */
class PickLocalization extends LeafletMapBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.pick_localization.name',
            'description' => 'initbiz.leafletpro::lang.components.pick_localization.description'
        ];
    }

    public function defineProperties()
    {
        return $this->leafletProperties() + [
            'centerLatLon' => [
                'title'             => 'initbiz.leafletpro::lang.components.pick_localization.center_lon_lat',
                'description'       => 'initbiz.leafletpro::lang.components.pick_localization.center_lon_lat_desc',
                'type'              => 'string',
                'default'           => '51.505, -0.09'
            ],
        ];
    }

    public function makeInitialCenterLatLon()
    {
        $centerLatLon = $this->property('centerLatLon');

        return $centerLatLon;
    }
}
