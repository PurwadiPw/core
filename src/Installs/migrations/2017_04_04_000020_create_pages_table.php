<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template', 50);
            $table->tinyInteger('active')->default(1);
            $table->integer('core_menus_id')->unsigned();
            $table->foreign('core_menus_id')->references('id')->on('core_menus')->onDelete('cascade');
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
        if (Schema::hasTable('core_pages')) {
            Schema::drop('core_pages');
        }
    }
}
