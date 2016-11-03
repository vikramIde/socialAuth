<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Testdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //public function up()
       Schema::create('testdb', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->string('phone');
           $table->date('dob');
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
        //
    }
}
