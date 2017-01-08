<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerCampaignPercentUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared('
      CREATE TRIGGER tr_Mission_Campaign_Update AFTER UPDATE ON `missions` FOR EACH ROW
        BEGIN

          DECLARE totalPercent int;

          SELECT AVG(percent_complete) INTO totalPercent
          FROM missions m
            WHERE campaign_id = OLD.campaign_id;


          UPDATE campaigns
        	SET `percent_complete` = totalPercent
        	WHERE `id` = OLD.campaign_id;
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
      DB::unprepared('DROP TRIGGER tr_Mission_Campaign_Update');
    }
}
