<?php namespace Initbiz\LeafletPro\Models;

use Model;

/**
 * GeneralSettings Model
 */
class Settings extends Model
{
    public $implement = [
        'System.Behaviors.SettingsModel'
    ];

    public $settingsCode = 'initbiz_lafletpro_settings';

    public $settingsFields = 'fields.yaml';
}
