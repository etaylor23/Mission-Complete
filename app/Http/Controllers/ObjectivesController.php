<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mission;
use App\Objective;
use Request;
use Auth;
use App\URLParser\URLParserMain;
use App\AssetCreatedDate\AssetCreatedDateCore;
use Carbon\Carbon;



class ObjectivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $objectiveCreated = Objective::create($newObjective);

        return redirect('campaign/'.$campaignSlug.'/mission/'.$missionSlug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $mission_slug, $objective_slug)
    {
      /*
       * Check that the user owns the campaign and get the campaign that matches the current slug, then get all of the missions, then get all of the objectives and find the one that matches the current objective id
       * Will return null if the user does not own the campaign
       * Route: /campaign/{slug}/mission/{mission_slug}/objective/{objective_slug}
       *        /campaign/create-a-new-app/mission/create-a-map/objective/new-objective
       * Returns: An objective object
       */

       $campaign = Auth::user()
                  ->Campaign
                  ->where('slug', $slug)
                  ->first();
       $mission =  $campaign
                  ->Mission
                  ->where('mission_slug', $mission_slug)
                  ->first();

      $objective = $mission
                  ->Objective
                  ->where('objective_slug', $objective_slug)
                  ->first();

      $objective->maintenance_length = date('Y-m-d', strtotime($objective->maintenance_length));


     $assetCreated = new AssetCreatedDateCore();
     $assetCreatedRelative = $assetCreated->AssetCreatedRelative($objective->created_at);

      /*
       * If an objective has been received then move to an objective view and pass the objective information
       */
      if(!empty($objective)) {
        return view('objective')
                ->with('objective', $objective)
                ->with('mission', $mission)
                ->with('campaign', $campaign)
                ->with('timeSinceCreation', $assetCreatedRelative);
      } else {
        return view('404')->with('notFoundType', 'mission');
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Mission $missionAlias, Request $request, $slug, $mission_slug, $objective_slug)
    {



        $request = Request::all();



        $objective = Objective
                    ::where('objective_slug', $objective_slug)
                    ->first();

                    $objectiveName = $objective
                                    ->name;


        if($request['done'] !== "0") {
            //$maintenance_aggression = $request['maintenance_aggression'];
            $next_maintenance_instance_date = Carbon::now()->addDays($request['maintenance_aggression'])->toDateString();
            //dd($next_maintenance_instance_date);
            $objective->proof_of_completion = $request['proof_of_completion'];
            $objective->maintenance_plan = $request['maintenance_plan'];
            $objective->maintenance_aggression = $request['maintenance_aggression'];
            $objective->next_maintenance_instance_date = $next_maintenance_instance_date;
            $objective->maintenance_length = $request['maintenance_length'];
        }

        $objective->done = $request['done'];

        $objective->save();

        return redirect('campaign/'.$slug.'/mission/'.$mission_slug.'/objective/'.$objective_slug)
              ->with('updatedObjective', $objectiveName . ' was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $mission_slug, $objective_slug)
    {
      $objective = Objective
                  ::where('objective_slug', $objective_slug)
                  ->first();
      $objectiveId = $objective
                  ->id;
      $objectiveName = $objective
                      ->name;
      Objective::destroy($objectiveId);

      return redirect('campaign/'.$slug.'/mission/'.$mission_slug)
              ->with('deletedObjective', $objectiveName . ' was deleted');
    }
}
