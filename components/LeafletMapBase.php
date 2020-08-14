<?php namespace Initbiz\LeafletPro\Components;

use Cms\Classes\ComponentBase;
use Initbiz\LeafletPro\Models\Marker;
use Initbiz\LeafletPro\Classes\Address;
use Initbiz\LeafletPro\Models\Settings;
use Initbiz\LeafletPro\Classes\AddressResolver;
use Initbiz\LeafletPro\Exceptions\EmptyResponse;
use Initbiz\LeafletPro\Contracts\AddressResolverInterface;

abstract class LeafletMapBase extends ComponentBase
{
    /**
     * Variable that stores longitude and latitude of the center of the map
     * in format "lon, lat", for example '51.505, -0.09'
     *
     * @var string
     */
    public $centerLatLon;

    /**
     * Initial zoom of the map
     *
     * @var string
     */
    public $initialZoom = '12';

    /**
     * Collection of Markers
     *
     * @var Collection
     */
    public $markers;

    /**
     * Protection of scrolling while pointing mouse on the map
     * need click to start using zoom
     *
     * @var string
     */
    public $scrollProtection = 'disable';

    /**
     * Array of active leaflet plugins enabled
     *
     * @var array
     */
    public $activePlugins;

    /**
     * Variable indicating that we want to override initial parameters
     * longitude, latitude and zoom of the initial map by parameters
     * in GET (in syntax like ?city=London&street=John's)
     *
     * @var bool
     */
    public $getOverriding = false;

    /**
     * When using GET overriding, the variable stores the resolved address
     *
     * @var Address
     */
    public $resolvedAddress;

    protected $pluginPropertySuffix = 'PluginEnabled';

    public function leafletProperties()
    {
        $properties = [
            'initialZoom' => [
                'title'             => 'initbiz.leafletpro::lang.components.zoom_title',
                'description'		=> 'initbiz.leafletpro::lang.components.zoom_description',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'initbiz.leafletpro::lang.components.zoom_validation_message',
                'default'			=> '12'
            ],
            'scrollProtection' => [
                'title'             => 'initbiz.leafletpro::lang.components.scroll_protection_title',
                'description'       => 'initbiz.leafletpro::lang.components.scroll_protection_description',
                'default'           => '1',
                'type'              => 'checkbox',
            ],
            'getOverriding' => [
                'title'             => 'initbiz.leafletpro::lang.components.get_overriding_title',
                'description'       => 'initbiz.leafletpro::lang.components.get_overriding_description',
                'default'           => '0',
                'type'              => 'checkbox',
            ]
        ];

        return $properties + $this->getLeafletPluginsProperties();
    }

    public function defineProperties()
    {
        return $this->leafletProperties();
    }

    public function onRun()
    {
        $leafletJs = [];
        $leafletCss = [];
        $activePlugins = [];

        $leafletJs[] = 'assets/node_modules/leaflet/dist/leaflet.js';
        $leafletCss[] = 'assets/node_modules/leaflet/dist/leaflet.css';

        foreach ($this->getLeafletPlugins() as $pluginCode => $pluginDef) {
            if ($this->property($pluginCode . $this->pluginPropertySuffix)) {
                $activePlugins[] = $pluginCode;

                if (isset($pluginDef['jsPath'])) {
                    $leafletJs[] = $pluginDef['jsPath'];
                }
                if (isset($pluginDef['cssPath'])){
                    $leafletCss[] = $pluginDef['cssPath'];
                }
            }
        }

        $this->addJs($leafletJs);
        $this->addCss($leafletCss);

        $this->getOverriding = ($this->property('getOverriding') === '1') ? true : false;

        $this->initialZoom = $this->makeInitialZoom();

        // Leaflet use scrollWheelZoom param, to it's negated scrollProtection
        $this->scrollProtection = ($this->property('scrollProtection') === "0") ? 'enable' : 'disable';

        $this->markers = $this->makeMarkers();
        $this->centerLatLon = $this->makeInitialCenterLatLon();

        $this->page['activeLeafletPlugins'] = $activePlugins;
    }

    public function makeMarkers()
    {
        return Marker::published()->get();
    }

    public function makeInitialZoom()
    {
        $initialZoom = $this->property('initialZoom');

        if ($this->getOverriding) {
            $data = get();
            $initialZoom = 6;

            if (!empty($data['city'])) {
                $initialZoom = 12;
            }

            if (!empty($data['street'])) {
                $initialZoom = 15;
            }
        }

        return $initialZoom;
    }

    public function makeResolvedAddress()
    {
        if ($this->resolvedAddress) {
            return $this->resolvedAddress;
        }

        $data = get();

        $address = new Address();
        $address->setFromArray($data);
        $this->resolvedAddress = $resolvedAddress = $this->resolveAddress($address);
        return $resolvedAddress;
    }

    public function makeInitialCenterLatLon()
    {
    }

    protected function resolveAddress(Address $address, AddressResolverInterface $addressResolver = null): Address
    {

        if (is_null($addressResolver)) {
            $addressResolver = new AddressResolver();
        }
        try {
            $response = $addressResolver->resolv($address);
        } catch (EmptyResponse $e) {
            // The response is empty - that means the resolved couldn't manage
            // to resolve the address, nothing bad happens though
            $address->irresolvable = true;
            return $address;
        } catch (\Throwable $e) {
            if (env('APP_DEBUG')) {
                throw new $e;
            } else {
                trace_log($e);
                return $address;
            }
        }

        $firstFound = $response[0];

        $address->setLon($firstFound['lon']);
        $address->setLat($firstFound['lat']);

        return $address;
    }

    /**
     * Makes properties definitions for Leaflet plugins, right now only checkboxes if enable the plugin for the component
     * @return array component properties definitions for this component
     */
    protected function getLeafletPluginsProperties()
    {
        $properties = [];

        foreach ($this->getLeafletPlugins() as $pluginCode => $pluginDef) {
            $property = [
                'title'         => $pluginDef['title'],
                'description'   => $pluginDef['description'],
                'type'          => 'checkbox',
                'group'         => 'initbiz.leafletpro::lang.components.leafletmap.plugins_group',
                'default'       => 0,
            ];

            $properties[$pluginCode . $this->pluginPropertySuffix] = $property;
        }

        return $properties;
    }

    /**
     * Registers Leaflet plugins to be used in the component
     * @return array Leaflet plugins
     */
    protected function getLeafletPlugins()
    {
        return [
            'colorfilter' => [
                'title'       => 'initbiz.leafletpro::lang.leafletmap_plugins.colorfilter_name',
                'description' => 'initbiz.leafletpro::lang.leafletmap_plugins.colorfilter_desc',
                'jsPath'      => 'assets/node_modules/leaflet.tilelayer.colorfilter/src/leaflet-tilelayer-colorfilter.js',
            ]
        ];
    }

    // Helpers

    public function getMarkerIconUrl()
    {
        $settings = Settings::instance();
        return $settings->getIconUrl();
    }
}
