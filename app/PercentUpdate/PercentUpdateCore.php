<?php

namespace App\PercentUpdate;

class PercentUpdateCore
{


    private $completedSiblings;
    private $percentComplete;

    public function updateParentPercentage($siblings, $parent) {

      $this->completedSiblings = $siblings
                            -> where('done', 1);

      $this->percentComplete = 0;
      if(count($this->completedSiblings) > 0) {
        $this->percentComplete = count($this->completedSiblings) / count($siblings) * 100;
      }

      $parent->percent_complete = round($this->percentComplete);
      return $parent->save();

    }
}

?>
