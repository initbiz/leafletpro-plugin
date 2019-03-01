<?php return [
    'plugin' => [
        'name' => 'Leaflet Pro',
        'description' => 'Use Leaflet service fully featured',
    ],
    'components' => [
        'leafletmap' => [
            'name' => 'Leaflet map',
            'description' => 'Embed Leaflet map',
            'center_long_lat' => 'Long and lat of center',
            'center_long_lat_desc' => 'Longitude and latitude of center of the map',
            'zoom_title' => 'Initial zoom',
            'zoom_description' => 'Initial zoom of the map',
            'zoom_validation_message' => 'The value must be an integer',
            'scroll_protection_title' => 'Scroll protection',
            'scroll_protection_description' => 'Enforce user not to zoom the map using scroll',
        ],
    ],
    'exceptions' => [
        'address_resolver_empty_response' => 'Address resolver returned empty value',
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
        'settings_access' => 'Manage Leaflet Pro settings',
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
        'refresh_long_lat_label' => 'Refresh longitude and latitude',
        'refresh_long_lat_button' => 'Get long and lat params using address',
    ],
    'address_resolver' => [
        'thoroughfare_required' => '',
    ],
    'settings' => [
        'menu_category' => 'Leaflet Maps',
        'label' => 'LeafletPro',
        'description' => 'LeafletPro general settings',
        'resolvers_tab' => 'Resolvers',
        'nominatim_url' => 'URL of Nominatim service',
        'nominatim_url_comment' => 'Read more info about Nominatim service <a href="https://operations.osmfoundation.org/policies/nominatim/" target="_blank">here</a>',
    ]
];
