<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerMissionPercentDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared('
        CREATE TRIGGER tr_Objective_Mission_Delete AFTER DELETE ON `objectives` FOR EACH ROW
        BEGIN
          DECLARE allObjectives int;
          DECLARE completedObjectives int;

          SELECT COUNT(id) INTO allObjectives
          FROM objectives o
            WHERE mission_id = OLD.mission_id;

          SELECT COUNT(id) INTO completedObjectives
          FROM objectives o
            WHERE mission_id = OLD.mission_id
            AND done = 1;

          UPDATE missions
          SET `percent_complete` = round(completedObjectives / allObjectives * 100)
          WHERE `id` = OLD.mission_id;
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
