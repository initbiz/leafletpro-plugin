<?php namespace Initbiz\LeafletPro\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMarkersTable extends Migration
{
    public function up()
    {
        Schema::create('initbiz_leafletpro_markers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('cluster_id')->unsigned()->nullable();
            $table->boolean('is_published')->default(true);
            $table->text('popup_content')->nullable();
            $table->string('lon');
            $table->string('lat');
            $table->text('additional_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initbiz_leafletpro_markers');
    }
}
