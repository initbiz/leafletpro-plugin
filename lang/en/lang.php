<?php return [
    'plugin' => [
        'name' => 'Leaflet Pro',
        'description' => 'Use Leaflet service fully featured',
    ],
    'components' => [
        'leafletmap' => [
            'name' => 'Leaflet map',
            'description' => 'Embed Leaflet map',
            'center_lon_lat' => 'Lon and lat of center',
            'center_lon_lat_desc' => 'Longitude and latitude of center of the map',
            'zoom_title' => 'Initial zoom',
            'zoom_description' => 'Initial zoom of the map',
            'zoom_validation_message' => 'The value must be an integer',
            'plugins_group' => 'Leaflet plugins',
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
        'street' => 'Street',
        'street_comment' => 'May include building no',
        'lon' => 'Longitude',
        'lat' => 'Latitude',
        'postal_code' => 'Postal code',
        'city' => 'City',
        'country' => 'Country',
        'country_empty_option' => 'Select country',
        'is_published' => 'Published',
        'popup_content' => 'Popup content',
        'refresh_lon_lat_label' => 'Refresh longitude and latitude',
        'refresh_lon_lat_button' => 'Get long and lat params using address',
        'delete_confirm' => 'Are you sure you want to remove the marker?',
        'cluster' => 'Cluster',
        'cluster_comment' => 'After you select cluster empty address fields will be seeded with the cluster\'s address',
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
