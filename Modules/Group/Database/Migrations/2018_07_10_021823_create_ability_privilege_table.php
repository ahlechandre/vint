<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilityPrivilegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_privilege', function (Blueprint $table) {
            // Ability relation.
            $table->integer('ability_id')
                ->unsigned();
            $table->foreign('ability_id')
                ->references('id')
                ->on('abilities');
            // Privilege relation.
            $table->integer('privilege_id')
                ->unsigned();
            $table->foreign('privilege_id')
                ->references('id')
                ->on('privileges');                
            $table->primary(['ability_id', 'privilege_id']);
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
        Schema::dropIfExists('ability_privilege');
    }
}
