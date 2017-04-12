<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_pages_contents', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('page_id')->unsigned();
            $table->string('variable');
            $table->foreign('page_id')->references('id')->on('core_pages')->onDelete('cascade');

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
        if (Schema::hasTable('core_pages_contents')) {
            Schema::drop('core_pages_contents');
        }
    }
}
