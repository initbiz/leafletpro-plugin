<?php namespace Initbiz\LeafletPro\Controllers;

use Lang;
use Request;
use BackendMenu;
use Backend\Classes\Controller;
use RainLab\Location\Models\Country;
use October\Rain\Exception\ApplicationException;
use Initbiz\LeafletPro\Classes\AddressResolver;

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

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Initbiz.LeafletPro', 'leafletpro-main-menu', 'leafletpro-side-menu-markers');
    }

    public function onLongLatRefresh()
    {
        $markerInputs = Request::input('Marker');
        $thoroughfare = $markerInputs['thoroughfare'];
        $city = $markerInputs['city'];
        if (!empty($markerInputs['country'])) {
            $country = Country::find($markerInputs['country'])->name;
        }

        $addressResolver = new AddressResolver();

        $response = $addressResolver->resolv($thoroughfare, $city, $country);

        //TODO: to consider pop up with other possibilities, right now getting first element
        if (empty($response)) {
            throw new ApplicationException(Lang::get('initbiz.leafletpro::lang.exceptions.address_resolver_empty_response'));
        }

        $address = $response[0];

        $result = [
            'lat' => $address['lat'],
            'long' => $address['lon'],
        ];

        return $result;
    }
}
