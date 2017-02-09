<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Mission;
use Auth;
use Request;
use App\AssetCreatedDate\AssetCreatedDateCore;



class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::all();
        return $campaigns;
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
         * Grab the incoming request to create a new campaign
         * Returns: The request data object
         */
        $newCampaign = Request::all();

        /*
         * Modify the request data to link the new campaign to a user
         * Modify the request data to use the provided name as a slug/url to the campaign
         */
        $newCampaign['user_id'] = Auth::user()->id;
        $newCampaign['slug'] = str_slug($newCampaign['name']);

        /*
         * Create the campaign
         * Returns: true or error
         */
        Campaign::create($newCampaign);

        /*
         * Redirect the user to the dashboard
         */
        return redirect('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        /*
         * Check which that the user owns the campaign and get the campaign that matches the current slug
         * Route: /campaign/{slug}
         *        /campaign/create-a-new-app
         * Returns: A campaign object
         */
        $campaign = Auth::user()
                    ->Campaign
                    ->where('slug', $slug)
                    ->first();

        /*
         * Get all of the missions that are related to the current campaign
         * Returns: Array of unfiltered missions
         * If: There are missions filter them into open and completed missions
         * Else: set open and completed missions to null
         */
        if(!empty($campaign)) {
            $relatedMissions          = $campaign
                                      ->Mission;

            $missionClosestToCompletion = $relatedMissions
                                            ->sortByDesc('percent_complete')
                                            ->first();

            /*
             * Filter into open missions and completed missions
             * Returns: Array of filtered missions
             */
            $relatedOpenMissions      = $relatedMissions
                                      ->where('done', 0);

            $relatedCompletedMissions = $relatedMissions
                                        ->where('done', 1);

        } else {
            $totalMissions = 0;
            $relatedOpenMissions = null;
            $relatedCompletedMissions = null;
        }

        /*
         * If there are open missions and completed missions...
         * Based on how many completed missions there are versus total missions create a percentage
         * Returns: An integer
         */
        $totalMissions = count($relatedOpenMissions) + count($relatedCompletedMissions);
        $percentComplete = 0;
        if($totalMissions > 0) {
            $percentComplete = count($relatedCompletedMissions) / $totalMissions * 100;
        }

        $assetCreated = new AssetCreatedDateCore();
        $assetCreatedRelative = $assetCreated->AssetCreatedRelative($campaign->created_at);

        return view('campaign')
                ->with('campaign', $campaign)
                ->with('relatedMissions', $relatedMissions)
                ->with('timeSinceCreation', $assetCreatedRelative)
                ->with('missionClosestToCompletion', $missionClosestToCompletion);
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
    public function destroy($slug)
    {
        $campaign = Campaign
                    ::where('slug', $slug)
                    ->first();

        $campaignId = $campaign
                    ->id;
        $campaignName = $campaign
                        ->name;

        Campaign::destroy($campaignId);
        return redirect('dashboard');

    }
}
