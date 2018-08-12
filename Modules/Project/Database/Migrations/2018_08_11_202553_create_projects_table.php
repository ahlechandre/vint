<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            // Grupo.
            $table->integer('group_id')
                ->unsigned();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
            // Programa.
            $table->unsignedInteger('program_id')
                ->nullable();
            $table->foreign('program_id')
                ->references('id')
                ->on('programs');
            // Usuário (criador).
            $table->integer('user_id')
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            // Cordenador do projeto.
            $table->integer('coordinator_user_id')
                ->unsigned();
            $table->foreign('coordinator_user_id')
                ->references('member_user_id')
                ->on('servants');
            // Orientador do projeto.
            $table->unsignedInteger('leader_user_id')
                ->nullable();
            $table->foreign('leader_user_id')
                ->references('member_user_id')
                ->on('servants');
            // Apoiador do projeto.
            $table->unsignedInteger('supporter_user_id')
                ->nullable();
            $table->foreign('supporter_user_id')
                ->references('member_user_id')
                ->on('collaborators');
            // Atributos.
            $table->string('name');
            $table->string('slug')
                ->unique();
            $table->text('description')
                ->nullable();
            $table->timestamp('start_on');
            $table->timestamp('finish_on')
                ->nullable();
            $table->boolean('is_approved')
                ->default(false);
            $table->boolean('is_active')
                ->default(true);
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
        Schema::dropIfExists('projects');
    }
}
