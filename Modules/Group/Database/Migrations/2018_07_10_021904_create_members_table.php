<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            // User relation.
            $table->integer('user_id')
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->primary('user_id');
            // Group relation.
            $table->integer('group_id')
                ->unsigned();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
            // Member type relation.
            $table->integer('member_type_id')
                ->unsigned();
            $table->foreign('member_type_id')
                ->references('id')
                ->on('member_types');
            // Other attributes.
            $table->string('cpf')
                ->unique();
            $table->text('description')
                ->nullable();
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
        Schema::dropIfExists('members');
    }
}
