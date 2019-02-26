<?php namespace Initbiz\LeafletPro;

use Backend;
use System\Classes\PluginBase;

/**
 * LeafletPro Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Initbiz\LeafletPro\Components\LeafletMap' => 'leafletmap',
        ];
    }
}
