<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_student', function (Blueprint $table) {
            // Projeto.
            $table->integer('project_id')
                ->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');
            // Aluno.
            $table->integer('student_user_id')
                ->unsigned();
            $table->foreign('student_user_id')
                ->references('member_user_id')
                ->on('students');
            // Bolsista.
            $table->boolean('is_scholarship')
                ->default(false);
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
        Schema::dropIfExists('project_student');
    }
}
