<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_role_permission', function (Blueprint $table) {
            // Group role relation.
            $table->integer('group_role_id')
                ->unsigned();
            $table->foreign('group_role_id')
                ->references('id')
                ->on('group_roles');
            // Permission relation.
            $table->integer('permission_id')
                ->unsigned();
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions');
            $table->primary(['group_role_id', 'permission_id']);
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
        Schema::dropIfExists('group_role_permission');
    }
}
