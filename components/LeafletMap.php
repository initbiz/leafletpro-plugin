<?php namespace Initbiz\LeafletPro\Components;

use Cms\Classes\ComponentBase;
use Initbiz\LeafletPro\Models\Marker;

class LeafletMap extends ComponentBase
{
    protected $pluginPropertySuffix = 'PluginEnabled';

    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.leafletmap.name',
            'description' => 'initbiz.leafletpro::lang.components.leafletmap.description'
        ];
    }

    public function defineProperties()
    {
        $properties = [
            'centerLongLat' => [
                'title'             => 'initbiz.leafletpro::lang.components.leafletmap.center_long_lat',
                'description'		=> 'initbiz.leafletpro::lang.components.leafletmap.center_long_lat_desc',
                'type'              => 'string',
                'default'			=> '51.505, -0.09'
            ],
            'initialZoom' => [
                'title'             => 'initbiz.leafletpro::lang.components.leafletmap.zoom_title',
                'description'		=> 'initbiz.leafletpro::lang.components.leafletmap.zoom_description',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'initbiz.leafletpro::lang.components.leafletmap.zoom_validation_message',
                'default'			=> '12'
            ],
            'scrollProtection' => [
                'title'             => 'initbiz.leafletpro::lang.components.leafletmap.scroll_protection_title',
                'description'       => 'initbiz.leafletpro::lang.components.leafletmap.scroll_protection_description',
                'default'           => 'false',
                'type'              => 'checkbox',
            ]
        ];

        return $properties + $this->getLeafletPluginsProperties();
    }

    public function onRun()
    {
        $leafletJs = [];
        $leafletCss = [];
        $activePlugins = [];

        $leafletJs[] = 'assets/node_modules/leaflet/dist/leaflet.js';
        $leafletCss[] = 'assets/node_modules/leaflet/dist/leaflet.css';

        foreach ($this->getLeafletPlugins() as $pluginCode => $pluginDef) {
            if ($this->property($pluginCode . $this->pluginPropertySuffix)) {
                $activePlugins[] = $pluginCode;
                $leafletJs[] = $pluginDef['jsPath'];
                $leafletCss[] = $pluginDef['cssPath'];
            }
        }

        $this->addJs($leafletJs);

        $this->addCss($leafletCss);

        $this->page['activeLeafletPlugins'] = $activePlugins;
        $this->page['centerLongLat'] = $this->property('centerLongLat');
        $this->page['initialZoom'] = $this->property('initialZoom');
        $this->page['scrollProtection'] = $this->property('scrollProtection');

        //TODO: filtering markers by category and using only one marker
        $this->page['markers'] = Marker::published()->get();
    }

    protected function getLeafletPluginsProperties()
    {
        $properties = [];

        foreach ($this->getLeafletPlugins() as $pluginCode => $pluginDef) {
            $property = [
                'title'         => $pluginDef['title'],
                'description'   => $pluginDef['description'],
                'type'          => 'checkbox',
                'default'       => 0,
            ];

            $properties[$pluginCode . $this->pluginPropertySuffix] = $property;
        }

        return $properties;
    }

    protected function getLeafletPlugins()
    {
        $plugins = [
            'markercluster' => [
                'title' => 'initbiz.leafletpro::lang.leafletmap_plugins.markercluster_name',
                'description' => 'initbiz.leafletpro::lang.leafletmap_plugins.markercluster_desc',
                'jsPath' => 'assets/node_modules/leaflet.markercluster/dist/leaflet.markercluster-src.js',
                'cssPath' => 'assets/node_modules/leaflet.markercluster/dist/MarkerCluster.css',
            ]
        ];

        return $plugins;
    }
}
