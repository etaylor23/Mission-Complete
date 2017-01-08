<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Mission;
use Request;
use Auth;
use App\URLParser\URLParserMain;
use App\AssetCreatedDate\AssetCreatedDateCore;

class MissionsContoller extends Controller
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
    public function store() {
        $newMission = Request::all();

        $urlParser = new URLParserMain();
        $slug = $urlParser->getUrlPart(Request::server('HTTP_REFERER'), 'campaign');

        $campaignId = Auth::user()
                   ->Campaign
                   ->where('slug', $slug)
                   ->first()
                   ->toArray()['id'];

        $newMission['campaign_id'] = $campaignId;
        $newMission['mission_slug'] = str_slug($newMission['name']);

        $missionCreated = Mission::create($newMission);

        return redirect('campaign/'.$slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $mission_slug) {

        /*
        * Check that the user owns the campaign and get the campaign that matches the current slug, then get all of the missions and find the one that matches the current mission id
        * Will return null if the user does not own the campaign
        * Route: /campaign/{slug}/mission/{id}
        *        /campaign/create-a-new-app/mission/8
        * Returns: A mission object
        */

        $campaign = Auth::user()
                   ->Campaign
                   ->where('slug', $slug)
                   ->first();
        $mission =  $campaign
                   ->Mission
                   ->where('mission_slug', $mission_slug)
                   ->first();

         /*
          * Get all of the missions that are related to the current campaign
          * Returns: Array of unfiltered missions
          */
         if(!empty($mission)) {
             $relatedObjectives          = $mission
                                           ->Objective;


             $assetCreated = new AssetCreatedDateCore();
             $assetCreatedRelative = $assetCreated->AssetCreatedRelative($mission->created_at);

             /*
              * Filter into open missions and completed missions
              * Returns: Array of filtered missions
              */
             $relatedOpenObjectives      = $relatedObjectives
                                       ->where('done', 0);



             $relatedCompletedObjectives = $relatedObjectives
                                         ->where('done', 1);



         } else {
             $totalObjectives = 0;
             $relatedOpenObjectives = null;
             $relatedCompletedObjectives = null;
         }


        if(is_null($mission)) {
           return view('404')->with('notFoundType', 'mission');
        } else {
           return view('mission')
                   ->with('mission', $mission)
                   ->with('campaign', $campaign)
                   ->with('relatedObjectives', $relatedObjectives)
                   ->with('timeSinceCreation', $assetCreatedRelative);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($slug, $mission_slug) {

        $mission = Mission
                    ::where('mission_slug', $mission_slug)
                    ->first();
        $missionId = $mission
                    ->id;
        $missionName = $mission
                        ->name;

        Mission::destroy($missionId);

        return redirect('campaign/'.$slug)
                ->with('deletedMission', $missionName . ' was deleted');

     }
}
