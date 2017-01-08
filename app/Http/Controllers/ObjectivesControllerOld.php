<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mission;
use App\Objective;
use Request;
use Auth;
use App\URLParser\URLParserMain;



class ObjectivesController extends Controller
{
  public function showObjective($slug, $mission_slug, $objective_slug) {
      /*
       * Check that the user owns the campaign and get the campaign that matches the current slug, then get all of the missions, then get all of the objectives and find the one that matches the current objective id
       * Will return null if the user does not own the campaign
       * Route: /campaign/{slug}/mission/{mission_slug}/objective/{objective_slug}
       *        /campaign/create-a-new-app/mission/create-a-map/objective/new-objective
       * Returns: An objective object
       */
      $objective = Auth::user()
                  ->Campaign
                  ->where('slug', $slug)
                  ->first()
                  ->Mission
                  ->where('mission_slug', $mission_slug)
                  ->first()
                  ->Objective
                  ->where('objective_slug', $objective_slug)
                  ->first();

      /*
       * If an objective has been received then move to an objective view and pass the objective information
       */
      if(!empty($objective)) {
        return view('objective')
                ->with('objective', $objective);
      } else {
        return view('404')->with('notFoundType', 'mission');
      }
  }

  public function store() {
      /*
       * Store the request information
       */
      $newObjective = Request::all();

      /*
       * Find appropriate campaign and mission slugs in the referring URL
       */
      $urlParser = new URLParserMain();
      $campaignSlug = $urlParser->getUrlPart(Request::server('HTTP_REFERER'), 'campaign');
      $missionSlug = $urlParser->getUrlPart(Request::server('HTTP_REFERER'), 'mission');


      /*
       * Find the id of the mission that the user is trying to create an objective for
       */
      $missionId = Auth::user()
                  ->Campaign
                  ->where('slug', $campaignSlug)
                  ->first()
                  ->Mission
                  ->where('mission_slug', $missionSlug)
                  ->first()
                  ->id;

      /*
       * Add to the request payload: A mission id, a new objective slug and a perent complete score
       */
      $newObjective['mission_id'] = $missionId;
      $newObjective['objective_slug'] = str_slug($newObjective['name']);
      $newObjective['percent_complete'] = 50;

      $objectiveCreated = Objective::create($newObjective);


      /*
       * Get all objectives in this mission to work out a new percentage complete with
       * This should be moved to a global function as it is also used in dashboard controller
       */
      $objectives = $objectiveCreated->Mission->Objective;
      $completedObjectives = $objectives->where('done', 1);
      $openObjectives = $objectives->where('done', 0);

      $totalObjectives = count($openObjectives) + count($completedObjectives);

      $percentComplete = 0;
      if($totalObjectives > 0) {
          $percentComplete = round(count($completedObjectives) / $totalObjectives * 100);
      }


      $updatedMission = $objectiveCreated->Mission;
      //dd($updatedMission);
      $updatedMission->percent_complete = $percentComplete;

      //dd($updatedMission);

      $updatedMission->save();

      return redirect('campaign/'.$campaignSlug.'/mission/'.$missionSlug);
  }
}
