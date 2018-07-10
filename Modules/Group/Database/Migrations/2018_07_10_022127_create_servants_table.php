<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servants', function (Blueprint $table) {
            // Member relation.
            $table->integer('member_user_id')
                ->unsigned();
            $table->foreign('member_user_id')
                ->references('user_id')
                ->on('members');
            $table->primary('member_user_id');
            // Servant type relation.
            $table->integer('servant_type_id')
                ->unsigned();
            $table->foreign('servant_type_id')
                ->references('id')
                ->on('servant_types');            
            // Other attributes.
            $table->string('siape')
                ->unique();
            $table->softDeletes();
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
        Schema::dropIfExists('servants');
    }
}
