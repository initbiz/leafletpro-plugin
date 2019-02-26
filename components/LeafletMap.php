<?php namespace Initbiz\LeafletPro\Components;

use Cms\Classes\ComponentBase;

class LeafletMap extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.leafletmap_name',
            'description' => 'initbiz.leafletpro::lang.components.leafletmap_description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
}
