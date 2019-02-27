<?php namespace Initbiz\LeafletPro\Components;

use Cms\Classes\ComponentBase;

class LeafletMap extends ComponentBase
{
    protected $pluginPropertySuffix = 'PluginEnabled';

    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.leafletmap_name',
            'description' => 'initbiz.leafletpro::lang.components.leafletmap_description'
        ];
    }

    public function defineProperties()
    {
        return $this->getLeafletPluginsProperties();
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

        $this->page['activePlugins'] = $activePlugins;
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
