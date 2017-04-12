<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesContentsTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_pages_contents_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_contents_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');
            $table->text('content');

            $table->unique(['page_contents_id','locale']);
            $table->foreign('page_contents_id')->references('id')->on('core_pages_contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('core_pages_contents_translation')) {
            Schema::drop('core_pages_contents_translation');
        }
    }
}
