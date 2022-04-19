<?php namespace Initbiz\Leafletpro\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateGroupsTable Migration
 */
class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('initbiz_leafletpro_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('marker_icon_from', 20)->nullable();
            $table->string('marker_icon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initbiz_leafletpro_groups');
    }
}
