<?php

namespace Initbiz\LeafletPro\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddMarkerIconToMarkersTable extends Migration
{
    public function up()
    {
        Schema::table('initbiz_leafletpro_markers', function (Blueprint $table) {
            $table->string('marker_icon_from', 20)->nullable();
            $table->string('marker_icon')->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->foreign('group_id', 'initbiz_leafletpro_markers_group_id')->references('id')->on('initbiz_leafletpro_groups');
        });
    }

    public function down()
    {
        if (Schema::hasTable('initbiz_leafletpro_markers')) {
            Schema::table('initbiz_leafletpro_markers', function ($table) {
                $table->dropForeign('initbiz_leafletpro_markers_group_id');
            });
        }

        Schema::table('initbiz_leafletpro_markers', function (Blueprint $table) {
            $table->dropColumn('marker_icon_from');
            $table->dropColumn('marker_icon');
            $table->dropColumn('group_id');
        });
    }
}
