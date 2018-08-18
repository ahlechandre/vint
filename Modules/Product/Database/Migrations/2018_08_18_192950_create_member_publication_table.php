<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_publication', function (Blueprint $table) {
            // Projeto.
            $table->integer('member_user_id')
                ->unsigned();
            $table->foreign('member_user_id')
                ->references('user_id')
                ->on('members');
            // Publicação.
            $table->integer('publication_id')
                ->unsigned();
            $table->foreign('publication_id')
                ->references('id')
                ->on('publications');                
            // PK.
            $table->primary(['member_user_id', 'publication_id']);
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
        Schema::dropIfExists('member_publication');
    }
}
