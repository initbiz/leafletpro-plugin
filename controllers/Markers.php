<?php namespace Initbiz\LeafletPro\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

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
    }
}
