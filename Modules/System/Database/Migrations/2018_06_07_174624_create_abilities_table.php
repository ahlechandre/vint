<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            // Resource.
            $table->integer('resource_id')->unsigned();
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources');
            // Method.
            $table->integer('method_id')->unsigned();
            $table->foreign('method_id')
                ->references('id')
                ->on('methods');
            $table->unique(['resource_id', 'method_id']);
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
        Schema::dropIfExists('abilities');
    }
}
