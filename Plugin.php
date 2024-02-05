<?php

namespace Initbiz\LeafletPro;

use System\Classes\PluginBase;

/**
 * LeafletPro Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.Location', 'October.Drivers'];

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            \Initbiz\LeafletPro\Components\LeafletMap::class        => 'leafletmap',
            \Initbiz\LeafletPro\Components\SingleMarkerMap::class   => 'singleMarkerMap',
            \Initbiz\LeafletPro\Components\ListMarkersMap::class    => 'listMarkersMap',
            \Initbiz\LeafletPro\Components\PickLocalization::class  => 'pickLocalization',
        ];
    }

    public function registerPageSnippets()
    {
        return [
            'Initbiz\LeafletPro\Components\LeafletMap'      => 'leafletmap',
            'Initbiz\LeafletPro\Components\SingleMarkerMap' => 'singleMarkerMap',
        ];
    }
}
