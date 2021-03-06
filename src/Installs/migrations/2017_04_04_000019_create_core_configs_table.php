<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 50);
			$table->string('section', 100)->default("");
            $table->string('value_id', 255);
            $table->string('value_en', 255);
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
        Schema::drop('core_configs');
    }
}
