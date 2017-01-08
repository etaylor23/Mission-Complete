<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mission_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->text('proof_of_completion')->nullable();
            $table->text('maintenance_plan')->nullable();
            $table->integer('maintenance_aggression')->nullable();
            $table->timestamp('maintenance_length')->nullable();
            $table->timestamp('next_maintenance_instance_date')->nullable();
            $table->boolean('done');
            $table->string('objective_slug');
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
        Schema::dropIfExists('objectives');
    }
}
