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

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Initbiz.LeafletPro', 'leafletpro-main-menu', 'leafletpro-side-menu-groups');
    }

    /**
     * Deleted checked groups.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $groupId) {
                if (!$group = group::find($groupId)) continue;
                $group->delete();
            }

            Flash::success(Lang::get('initbiz.leafletpro::lang.groups.delete_selected_success'));
        } else {
            Flash::error(Lang::get('initbiz.leafletpro::lang.groups.delete_selected_empty'));
        }

        return $this->listRefresh();
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
