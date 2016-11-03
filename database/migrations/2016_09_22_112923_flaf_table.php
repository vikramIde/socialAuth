<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlafTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flag_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->unique();
            $table->boolean('imported');
            $table->integer('rows_imported');
            $table->integer('total_rows');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('flag_table');
    }
}
