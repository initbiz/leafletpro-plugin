<?php namespace Initbiz\LeafletPro;

use Event;
use System\Classes\PluginManager;
use Initbiz\LeafletPro\Models\Marker;
use Initbiz\CumulusCore\Models\Cluster;
use Initbiz\LeafletPro\Controllers\Markers;
use Initbiz\CumulusCore\Controllers\Clusters;

Event::listen('backend.form.extendFieldsBefore', function ($formWidget) {
    if (!$formWidget->model instanceof Marker) {
        return;
    }

    if (!PluginManager::instance()->exists('Initbiz.CumulusCore')) {
        return;
    }

    $clusterField = [];
    $clusterField['cluster_id'] = [
        'label'   => 'Cluster',
        'type'   => 'dropdown',
        'emptyOption'   => 'Select cluster',
    ];

    $fields = $formWidget->fields;

    $fields['name']['dependsOn'] = 'cluster_id';
    $fields['street']['dependsOn'] = 'cluster_id';
    $fields['postal_code']['dependsOn'] = 'cluster_id';
    $fields['city']['dependsOn'] = 'cluster_id';
    $fields['country_id']['dependsOn'] = 'cluster_id';

    $formWidget->fields = $clusterField + $fields;
});

Marker::extend(function ($model) {
    if (!PluginManager::instance()->exists('Initbiz.CumulusCore')) {
        return;
    }

    $model->belongsTo['cluster'] = ['Initbiz\CumulusCore\Models\Cluster'];

    $model->addDynamicMethod('getClusterIdOptions', function () {
        return Cluster::all()->pluck('name', 'id')->toArray();
    });
});

Cluster::extend(function ($model) {
    $model->hasMany['markers'] = ['Initbiz\LeafletPro\Models\Marker'];
});

Clusters::extendFormFields(function ($form, $model, $context) {
    if (!$model instanceof Cluster) {
        return;
    }
    //TODO: add relation controller for managing map markers
});
