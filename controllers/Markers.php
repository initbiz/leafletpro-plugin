<?php namespace Initbiz\LeafletPro\Controllers;

use Request;
use BackendMenu;
use Backend\Classes\Controller;
use RainLab\Location\Models\Country;
use Initbiz\LeafletPro\Models\Marker;

/**
 * Markers Back-end Controller
 */
class Markers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    /**
     * @var string HTML body tag class
     */
    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Initbiz.LeafletPro', 'leafletpro-main-menu', 'leafletpro-side-menu-markers');
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
