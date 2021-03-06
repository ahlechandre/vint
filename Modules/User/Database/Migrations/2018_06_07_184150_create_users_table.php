<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            // Role relation.
            $table->integer('user_type_id')
                ->unsigned();
            $table->foreign('user_type_id')
                ->references('id')
                ->on('user_types');
            // Attributes.
            $table->string('name');
            $table->string('username')
                ->unique();
            $table->string('email')
                ->unique();
            $table->string('password');
            $table->boolean('is_active')
                ->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
