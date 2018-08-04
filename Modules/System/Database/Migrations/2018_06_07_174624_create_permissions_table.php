<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            // Resource.
            $table->integer('resource_id')->unsigned();
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources');
            // Method.
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')
                ->references('id')
                ->on('actions');
            $table->unique(['resource_id', 'action_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
