<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Mission;
use Auth;
use Request;

class CampaignsController extends Controller
{
    public function index() {
        $campaigns = Campaign::all();
        return $campaigns;
    }

    public function showCampaign($slug) {
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
       */
      if(!empty($campaign)) {
          $relatedMissions          = $campaign
                                    ->Mission;


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


      return view('campaign')
              ->with('campaign', $campaign)
              ->with('relatedOpenMissions', $relatedOpenMissions)
              ->with('relatedCompletedMissions', $relatedCompletedMissions);
    }

    public function store() {
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

      if($newCampaign['done'] === "0") {
          $newCampaign['percent_complete'] = "0";
      } else {
          $newCampaign['percent_complete'] = "100";
      }

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

}
