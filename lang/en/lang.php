<?php return [
    'plugin' => [
        'name' => 'Leaflet Pro',
        'description' => 'Use Leaflet service fully featured',
    ],
    'components' => [
        'leafletmap_name' => 'Leaflet map',
        'leafletmap_description' => 'Embed Leaflet map',
    ],
    'leafletmap_plugins' => [
        'markercluster_name' => 'Marker Cluster',
        'markercluster_desc' => 'Marker Clustering plugin for Leaflet',
    ],
    'navigation' => [
        'main' => 'Leaflet maps',
        'markers' => 'Markers',
    ],
    'permissions' => [
        'leafletpro' => 'Leaflet Pro',
        'leafletpro_markers' => 'Manage markers',
        'settings_access_general' => 'Manage Leaflet Pro settings',
    ],
    'marker' => [
        'name' => 'Name',
        'thoroughfare' => 'Thoroughfare (address line)',
        'long' => 'Longitude',
        'lat' => 'Latitude',
        'city' => 'City',
        'country' => 'Country',
        'is_published' => 'Published',
        'description' => 'Description',
        'refresh_long_lat_button' => 'Get long and lat params from address using Nominatim',
    ],
];
