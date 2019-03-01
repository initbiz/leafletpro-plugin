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
