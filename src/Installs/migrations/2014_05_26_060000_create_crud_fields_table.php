<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('colname', 30);
            $table->string('label', 100);
            $table->integer('crud')->unsigned();
            $table->foreign('crud')->references('id')->on('cruds')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('field_type')->unsigned();
            $table->foreign('field_type')->references('id')->on('crud_field_types')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('unique')->default(false);
            $table->string('defaultvalue');
            $table->integer('minlength')->unsigned()->default(0);
            $table->integer('maxlength')->unsigned()->default(0);
            $table->boolean('required')->default(false);
            $table->text('popup_vals');
            $table->integer('sort')->unsigned()->default(0);
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
        Schema::drop('crud_fields');
    }
}
