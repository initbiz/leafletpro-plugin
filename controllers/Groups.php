<?php

namespace Initbiz\Leafletpro\Controllers;

use Lang;
use Flash;
use Request;
use BackendMenu;
use Backend\Classes\Controller;
use Initbiz\Leafletpro\Models\group;
use RainLab\Location\Models\Country;
use Initbiz\LeafletPro\Models\Marker;

/**
 * Groups Back-end Controller
 */
class Groups extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['initbiz.leafletpro.access_groups'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Initbiz.LeafletPro', 'leafletpro-main-menu', 'leafletpro-side-menu-groups');
    }

    public function onLatLonRefresh()
    {
        $markerInputs = Request::input('Marker');

        $marker = new Marker();
        $marker->street = $markerInputs['street'];
        $marker->city = $markerInputs['city'];
        if (!empty($markerInputs['country'])) {
            $country = Country::find($markerInputs['country']);
            $marker->country()->associate($country);
        }

        $marker->refreshLatLon();

        return $marker->getLatLon();
    }
}
