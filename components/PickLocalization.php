<?php

namespace Initbiz\LeafletPro\Components;

use Initbiz\LeafletPro\Components\LeafletMapBase;

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
}
