<?php

namespace Initbiz\LeafletPro\Components;

class ListMarkersMap extends LeafletMap
{
    public $zoomOnClick;

    /**
     * Collection of Groups
     *
     * @var Collection
     */
    public $groups;

    public function componentDetails()
    {
        return [
            'name'        => 'initbiz.leafletpro::lang.components.list_markers_map.name',
            'description' => 'initbiz.leafletpro::lang.components.list_markers_map.description'
        ];
    }

    public function defineProperties()
    {
        return parent::defineProperties() + [
            'zoomOnClick' => [
                'title'             => 'initbiz.leafletpro::lang.components.list_markers_map.zoom_on_click',
                'description'       => 'initbiz.leafletpro::lang.components.list_markers_map.zoom_on_click_desc',
                'type'              => 'string',
                'default'           => '17'
            ],
        ];
    }

    public function onRun()
    {
        parent::onRun();

        $this->zoomOnClick = $this->property('zoomOnClick', 17);
        $this->groups = $this->getGroups();
        $test = 'asd';
    }

    /**
     * Get groups
     *
     * @return Collection
     */
    public function getGroups()
    {
        return $this->markers->groupBy(function ($marker) {
            return $marker->group->slug ?? 'ungrouped';
        });
    }
}
