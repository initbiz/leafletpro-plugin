# Leaflet Pro

![LeafletPro banner](https://raw.githubusercontent.com/initbizlab/oc-leafletpro-plugin/master/docs/images/leafletpro_banner.png)

LeafletPro is an OctoberCMS plugin for easily embedding maps using [OpenStreetMap](https://www.openstreetmap.org) and [Leaflet](https://leafletjs.com/).

[OpenStreetMap](https://www.openstreetmap.org) is a collaborative project to create a free editable map of the world while [Leaflet](https://leafletjs.com/) is the leading open-source JavaScript library for mobile-friendly interactive maps.

## Installation

You can install the plugin using any of the following methods:

1. Install using [OctoberCMS marketplace](https://octobercms.com/plugin/initbiz-leafletpro)
1. Install using composer: `composer require initbiz/oc-leafletpro-plugin`
1. Clone the [GitHub repo](https://github.com/initbizlab/oc-leafletpro-plugin) to `plugins/initbiz/leafletpro` directory of your project and run composer install in your project's directory

The plugin will automatically install [maxhelias/php-nominatim](https://github.com/maxhelias/php-nominatim), which is used to query [Nominatim](https://wiki.openstreetmap.org/wiki/Nominatim) service. If you are going to use the Nominatim service, recall the [Nominatim usage policy](https://operations.osmfoundation.org/policies/nominatim/).

## Embed the map
You can embed a map using Leaflet map component.

![Leaflet map component](https://raw.githubusercontent.com/initbizlab/oc-leafletpro-plugin/master/docs/images/leafletmap_component.png)

As you see in the above screenshot you can specify a few parameters:
* Longitude and latitude of the center of the map being shown
* Initial zoom of the map
* Scroll protection to start zooming with scroll only after clicking the map
* Leaflet plugins - checkboxes for enabling Leaflet plugins for the component



## Customize popup content

![Custom marker popup with InIT.biz logo](https://raw.githubusercontent.com/initbizlab/oc-leafletpro-plugin/master/docs/images/marker_with_initbiz_popup.png)

The popup content is defined individually for every marker. By default it's seeded with the content of `plugins/initbiz/leafletpro/models/marker/_default_popup_content.htm`.

The partial can be easily overridden by creating `_default_popup_content.htm` file in your theme in `partials` directory. Remember that overriding the partial will not change current marker popups. This partial is used only as a seeder when popup content is empty while saving marker.

## Cumulus integration
The plugin is nicely integrated with the [Initbiz.CumulusCore](https://octobercms.com/plugin/initbiz-cumuluscore) plugin.

1. When cluster is created or updated (address changed), a marker is created or updated
1. When cluster is selected in create marker view address is refreshed from cluster's address

## TODO / Future plans
* Marker categories to filter markers on maps
* Single marker map
* Backend form widget for current lon / lat preview and for setting lon / lat using map marker
* Easy configurable marker icons for markers and categories from backend
* Add possibility to manage more than one marker by Cumulus clusters
* Pop up in backend with other possibilities for the same address (right now getting only the first element)
* Support Leaflet plugins
