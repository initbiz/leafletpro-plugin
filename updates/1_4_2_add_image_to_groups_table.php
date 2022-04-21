<?php

namespace Initbiz\LeafletPro\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddImageToGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('initbiz_leafletpro_groups', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::table('initbiz_leafletpro_groups', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
