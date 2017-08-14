<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Mission;
use App\Objective;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\ObjectiveComplete;
use \DB;



class DashboardController extends Controller
{
    public function index() {

      $campaigns = Auth::user()
                  ->Campaign;

      /**
      * For each campaign get the mission if its incomplete/complete
      **/
      $missions = [];
      foreach($campaigns as $missionValue) {
        $mission = $missionValue->Mission;
        array_push($missions, $mission);
      }

      $nextMaintenceInstanceDate = Carbon::now()->addDays(1)->toDateString().' 00:00:00';

      return view('dashboard')
              ->with('campaigns', $campaigns)
              ->with('missions', $missions)
              ->with('nextMaintenceInstanceDate', $nextMaintenceInstanceDate)
              ->with('following', count(Auth::user()->Follows))
              ->with('followers', count(Auth::user()->FollowedBy));

    }

    /*
    *   Update maintenance date for a particular objective
    */
    public function maintenanceComplete($objective_slug) {
      $objective = Objective::all()->where('objective_slug', $objective_slug)->first();
      $alertDate = new Carbon($objective->next_maintenance_instance_date);
      $resetDate = $alertDate->addDays($objective->maintenance_aggression)->toDateString().' 00:00:00';
      $objective->next_maintenance_instance_date = $resetDate;
      $objective->save();
      return redirect('dashboard');
    }

}
