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
        $currentUser = Auth::user();

        $currentUserSkills = array();
        $currentUserSkillsName = array();

        $currentUser->UserSkill->each(function($skill, $key) use(&$currentUserSkills, &$currentUserSkillsName) {
            array_push($currentUserSkills, $skill->Skill->id);
            array_push($currentUserSkillsName, $skill->Skill->skill_name);
        });

        $currentUserId = Auth::user()->id;
        $followPosts = \App\User
                    ::with(['Follows' => function($query) use(&$currentUserSkills) {
                        $query
                            ->with(['User.Posts' => function($postSkills) use(&$currentUserSkills) {
                                    $postSkills
                                    ->whereHas('PostSkill', function($subQuery) use(&$currentUserSkills) {
                                        $subQuery
                                            ->whereIn('skill_id', $currentUserSkills);
                                    })
                                    ->with(['PostSkill' => function($testSub) use(&$currentUserSkills) {
                                        $testSub
                                            ->with('Skill')
                                            ->get();
                                    }]);
                            }])
                            ->has('User.Posts.PostSkill')
                            ->get();
                    }])
                    ->where('users.id', '=', $currentUserId)
                    ->first();

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
              ->with('followPosts', $followPosts)
              ->with('currentUserSkillsName', $currentUserSkillsName)
              ->with('userId', Auth::user()->id);

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
