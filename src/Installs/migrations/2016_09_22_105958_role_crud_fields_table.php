<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleCrudFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_crud_fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('field_id')->unsigned();
			$table->foreign('field_id')->references('id')->on('crud_fields')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('access', ['invisible', 'readonly', 'write']);
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
        if (Schema::hasTable('role_crud_fields')) {
            Schema::drop('role_crud_fields');
        }
    }
}
