<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectiveCompletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

         public function up()
         {
             Schema::create('objective_completes', function (Blueprint $table) {
                 $table->increments('id');
                 $table->string('message');
                 $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('objective_completes');
    }
}
