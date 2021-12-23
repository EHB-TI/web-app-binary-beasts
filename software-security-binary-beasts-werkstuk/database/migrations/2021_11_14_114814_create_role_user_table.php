<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('role_user', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->unsigned();
                $table->bigInteger('role_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
                $table->foreign('role_id')->references('id')->on('roles');
            });
        }
        catch (Exception $exc)
        {
            error_log($exc);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
