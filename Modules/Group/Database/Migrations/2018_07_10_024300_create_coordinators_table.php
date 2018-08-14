<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinators', function (Blueprint $table) {
            // Group relation.
            $table->integer('group_id')
                ->unsigned();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
            // Member relation.
            $table->integer('coordinator_user_id')
                ->unsigned();
            $table->foreign('coordinator_user_id')
                ->references('member_user_id')
                ->on('servants');
            $table->boolean('is_vice')
                ->default(false);
            $table->primary(['group_id', 'coordinator_user_id']);
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
        Schema::dropIfExists('coordinators');
    }
}
