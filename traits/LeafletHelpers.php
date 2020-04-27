<?php namespace Initbiz\LeafletPro\Traits;

use Initbiz\LeafletPro\Models\Settings;

trait LeafletHelpers
{
    public function getMarkerIconUrl()
    {
        return Settings::get('marker_icon_url') ?? '/plugins/initbiz/leafletpro/assets/node_modules/leaflet/dist/images/marker-icon.png';
    }

}
