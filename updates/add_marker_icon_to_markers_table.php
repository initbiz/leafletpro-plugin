<?php

namespace Initbiz\LeafletPro\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMarkersTable extends Migration
{
    public function up()
    {
        Schema::table('initbiz_leafletpro_markers', function (Blueprint $table) {
            $table->string('marker_icon_from', 20)->nullable();
            $table->string('marker_icon')->nullable();
            $table->string('group_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('initbiz_leafletpro_markers', function (Blueprint $table) {
            $table->dropColumn('marker_icon_from')->nullable();
            $table->dropColumn('marker_icon')->nullable();
            $table->dropColumn('group_id')->nullable();
        });
    }
}
