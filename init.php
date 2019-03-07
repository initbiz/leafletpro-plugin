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
        'label'   => 'initbiz.leafletpro::lang.marker.cluster',
        'commentAbove'   => 'initbiz.leafletpro::lang.marker.cluster_comment',
        'type'   => 'dropdown',
        'span'   => 'right',
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

    $model->bindEvent('model.afterSave', function () use ($model) {
        if ($model->markers()->count() === 0) {
            // If cluster has no marker, create one
            if (!empty($model->city) && !empty($model->thoroughfare) && !empty($model->name)) {
                $marker = new Marker();
                $marker->name = $model->name;
                $marker->cluster_id = $model->id;
                $marker->street = $model->thoroughfare;
                $marker->city = $model->city;
                if (!empty($marker->country_id)) {
                    $country = Country::find($marker->country_id);
                    $marker->country()->associate($country);
                }
                if (!empty($marker->postal_code)) {
                    $marker->postal_code = $model->postal_code;
                }

                $marker->refreshLongLat();
                $marker->save();
            }
        } else {
            // else get first and if address updated than update marker
            if (!empty($model->city) && !empty($model->thoroughfare) && !empty($model->name)) {
                $marker = $model->markers()->first();

                $markerChanged = false;

                if ($marker->city !== $model->city) {
                    $marker->city = $model->city;
                    $markerChanged = true;
                }

                if ($marker->street !== $model->thoroughfare) {
                    $marker->street = $model->thoroughfare;
                    $markerChanged = true;
                }

                if ($marker->country_id !== $model->country_id) {
                    $marker->country_id = $model->country_id;
                    $markerChanged = true;
                }

                if ($marker->postal_code !== $model->postal_code) {
                    $marker->postal_code = $model->postal_code;
                    $markerChanged = true;
                }

                if ($markerChanged) {
                    $marker->refreshLongLat();
                    $marker->save();
                }
            }
        }
    });
});

Clusters::extendFormFields(function ($form, $model, $context) {
    if (!$model instanceof Cluster) {
        return;
    }
    //TODO: add relation controller for managing map markers
});
