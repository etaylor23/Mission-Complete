<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerCampaignPercentInsert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared('
      CREATE TRIGGER tr_Mission_Campaign_Insert AFTER INSERT ON `missions` FOR EACH ROW
      BEGIN

      	DECLARE totalPercent int;

      	SELECT AVG(percent_complete) INTO totalPercent
      	FROM missions m
      	WHERE campaign_id = NEW.campaign_id;


      	UPDATE campaigns
      	SET `percent_complete` = totalPercent
      	WHERE `id` = NEW.campaign_id;
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
