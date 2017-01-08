<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerMissionPercentInsert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared('
        CREATE TRIGGER tr_Objective_Mission_Insert AFTER INSERT ON `objectives` FOR EACH ROW
        BEGIN
          DECLARE allObjectives int;
          DECLARE completedObjectives int;

          SELECT COUNT(id) INTO allObjectives
          FROM objectives o
          WHERE mission_id = NEW.mission_id;

          SELECT COUNT(id) INTO completedObjectives
          FROM objectives o
          WHERE mission_id = NEW.mission_id
          AND done = 1;

          UPDATE missions
        	SET `percent_complete` = round(completedObjectives / allObjectives * 100)
        	WHERE `id` = NEW.mission_id;
        END
        ');
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
