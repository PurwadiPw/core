<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Pw\Core\Models\CrudFieldTypes;

class CreateCrudFieldTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_field_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->timestamps();
        });
        // Note: Do not edit below lines
        CrudFieldTypes::create(["name" => "Address"]);
        CrudFieldTypes::create(["name" => "Checkbox"]);
        CrudFieldTypes::create(["name" => "Currency"]);
        CrudFieldTypes::create(["name" => "Date"]);
        CrudFieldTypes::create(["name" => "Datetime"]);
        CrudFieldTypes::create(["name" => "Decimal"]);
        CrudFieldTypes::create(["name" => "Dropdown"]);
        CrudFieldTypes::create(["name" => "Email"]);
        CrudFieldTypes::create(["name" => "File"]);
        CrudFieldTypes::create(["name" => "Float"]);
        CrudFieldTypes::create(["name" => "HTML"]);
        CrudFieldTypes::create(["name" => "Image"]);
        CrudFieldTypes::create(["name" => "Integer"]);
        CrudFieldTypes::create(["name" => "Mobile"]);
        CrudFieldTypes::create(["name" => "Multiselect"]);
        CrudFieldTypes::create(["name" => "Name"]);
        CrudFieldTypes::create(["name" => "Password"]);
        CrudFieldTypes::create(["name" => "Radio"]);
        CrudFieldTypes::create(["name" => "String"]);
        CrudFieldTypes::create(["name" => "Taginput"]);
        CrudFieldTypes::create(["name" => "Textarea"]);
        CrudFieldTypes::create(["name" => "TextField"]);
        CrudFieldTypes::create(["name" => "URL"]);
        CrudFieldTypes::create(["name" => "Files"]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crud_field_types');
    }
}
