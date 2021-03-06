<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon', 50)->default("fa-cube");
            $table->string('type', 20)->default("module");
            $table->integer('crud_id')->unsigned();
            $table->foreign('crud_id')->references('id')->on('cruds')->onDelete('cascade');
            $table->integer('active')->unsigned()->default(1);
            $table->integer('is_backend')->unsigned()->default(1);
            $table->integer('parent')->unsigned()->default(0);
            $table->integer('hierarchy')->unsigned()->default(0);
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
        if (Schema::hasTable('core_menus')) {
            Schema::drop('core_menus');
        }
    }
}
