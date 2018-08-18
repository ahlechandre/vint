<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectPublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_publication', function (Blueprint $table) {
            // Projeto.
            $table->integer('project_id')
                ->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');
            // Publicação.
            $table->integer('publication_id')
                ->unsigned();
            $table->foreign('publication_id')
                ->references('id')
                ->on('publications');                
            // PK.
            $table->primary(['project_id', 'publication_id']);
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
        Schema::dropIfExists('project_publication');
    }
}
