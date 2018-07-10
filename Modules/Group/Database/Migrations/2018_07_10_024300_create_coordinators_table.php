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
        Schema::create('coordinations', function (Blueprint $table) {
            // Group relation.
            $table->integer('group_id')
                ->unsigned();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
            // Member relation.
            $table->integer('member_user_id')
                ->unsigned();
            $table->foreign('member_user_id')
                ->references('user_id')
                ->on('members');            
            $table->primary(['group_id', 'member_user_id']);
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
        Schema::dropIfExists('coordinations');
    }
}
