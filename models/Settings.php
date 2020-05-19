<?php namespace Initbiz\LeafletPro\Models;

use Model;
use System\Classes\MediaLibrary;

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

    /**
     * Get URL of the Leaflet marker icon
     *
     * @return string
     */
    public function getIconUrl()
    {
        $url = '';
        $from = $this->get('marker_icon_from') ?? 'url';

        if ($from === 'media') {
            $url = $this->get('marker_icon_media');
            $url = MediaLibrary::url($url);
        } elseif ($from === 'url') {
            $url = $this->get('marker_icon_url');
        }

        return $url;
    }
}
