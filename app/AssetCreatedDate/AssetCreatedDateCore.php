<?php

namespace App\AssetCreatedDate;
use Carbon\Carbon;


class AssetCreatedDateCore
{
    private $diffInDays;
    private $date;
    private $humanReadableCreated;

    public function AssetCreatedRelative($date)
    {
        $this->date = $date;
        $now = Carbon::now();
        $this->diffInDays = $now->diffInDays($this->date);
        $this->humanReadableCreated = Carbon::now()->subDays($this->diffInDays)->diffForHumans();
        return $this->humanReadableCreated;
    }
}

?>
