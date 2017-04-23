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
        // $currentUser->UserSkills->each(function($skill, $key) use(&$currentUserSkills) {
        //     $newSkill = array();
        //     echo $skill . "<br />";
        //     echo $skill ->Skill. "<br />";
        //     dd($skill->Skill);
        //     array_push($currentUserSkills, $skill->Skill->id);
        // });

        $currentUser->UserSkill->each(function($skill, $key) use(&$currentUserSkills) {
            array_push($currentUserSkills, $skill->Skill->id);
        });

        //dd($currentUserSkills);


        // // dd($currentUserSkills);
        // $currentUserId = Auth::user()->id;
        //
        // $followPosts = \App\User
        //             ::with(['Follows.User.Posts' => function($query) use(&$currentUserSkills) {
        //                 $query
        //                     ->with(['PostSkills' => function($postSkills) {
        //                         $postSkills
        //                             ->with('Skill');
        //                     }])
        //                     ->has('PostSkills')
        //                     ->whereHas('PostSkills', function($subQuery) use(&$currentUserSkills) {
        //                         $subQuery
        //                             ->whereIn('skill_id', $currentUserSkills);
        //                     })
        //                     ->get();
        //             }])
        //             ->where('users.id', '=', $currentUserId)
        //             ->first();
        $currentUserId = Auth::user()->id;
        $followPosts = \App\User
                    ::with(['Follows.User.Posts' => function($query) use(&$currentUserSkills) {
                        $query
                            ->with(['PostSkill' => function($postSkills) use(&$currentUserSkills) {
                                $postSkills
                                    ->whereIn('skill_id', $currentUserSkills)
                                    ->with('Skill')
                                    ->get();
                            }])
                            ->has('PostSkill')
                            ->whereHas('PostSkill', function($subQuery) use(&$currentUserSkills) {
                                $subQuery
                                    ->whereIn('skill_id', $currentUserSkills);
                            })
                            ->get();
                    }])
                    ->where('users.id', '=', $currentUserId)
                    ->first();

                    dd($followPosts);
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

      $user = \App\User::first();
    //   $message = \App\ObjectiveComplete::create([
    //       'user_id' => $user->id,
    //       'message' => "Hello you Chloe"
    //   ]);
      //
    //   event(new ObjectiveComplete($message, $user));

      return view('dashboard')
              ->with('campaigns', $campaigns)
              ->with('missions', $missions)
              ->with('nextMaintenceInstanceDate', $nextMaintenceInstanceDate);
            //   ->with('followPosts', $followPosts);

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
