<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleCrudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_crud', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('crud_id')->unsigned();
			$table->foreign('crud_id')->references('id')->on('cruds')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('acc_view');
            $table->boolean('acc_create');
            $table->boolean('acc_edit');
            $table->boolean('acc_delete');
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
        if (Schema::hasTable('role_crud')) {
            Schema::drop('role_crud');
        }
    }
}
