<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routs', function (Blueprint $table) {
            //$table->increments('id');
            $table->string('id');
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->smallInteger('distance')->unsigned();           
            $table->smallInteger('fare')->unsigned()->default(400);
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
        Schema::dropIfExists('routs');
    }
}
