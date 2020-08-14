<?php

namespace Initbiz\LeafletPro\Components;

use Initbiz\LeafletPro\Components\LeafletMapBase;

class LeafletMap extends LeafletMapBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.leafletmap.name',
            'description' => 'initbiz.leafletpro::lang.components.leafletmap.description'
        ];
    }

    public function defineProperties()
    {
        return $this->leafletProperties() + [
            'centerLatLon' => [
                'title'             => 'initbiz.leafletpro::lang.components.leafletmap.center_lon_lat',
                'description'       => 'initbiz.leafletpro::lang.components.leafletmap.center_lon_lat_desc',
                'type'              => 'string',
                'default'           => '51.505, -0.09'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getLeafletPlugins()
    {
        $plugins = parent::getLeafletPlugins();

        $plugins += [
            'markercluster' => [
                'title'       => 'initbiz.leafletpro::lang.leafletmap_plugins.markercluster_name',
                'description' => 'initbiz.leafletpro::lang.leafletmap_plugins.markercluster_desc',
                'jsPath'      => 'assets/node_modules/leaflet.markercluster/dist/leaflet.markercluster-src.js',
                'cssPath'     => 'assets/node_modules/leaflet.markercluster/dist/MarkerCluster.css',
            ]
        ];

        return $plugins;
    }


    public function makeInitialCenterLatLon()
    {
        $centerLatLon = $this->property('centerLatLon');

        if ($this->getOverriding) {
            $resolvedAddress = $this->makeResolvedAddress();
            $LatLon = $resolvedAddress->getLatLon();
            if (!empty($LatLon)) {
                $centerLatLon = $LatLon;
            }
        }

        return $centerLatLon;
    }
}
