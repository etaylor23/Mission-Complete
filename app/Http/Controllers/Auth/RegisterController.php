<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Campaign;
use App\Mission;
use App\Objective;


use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'vip' => 1,
            'firstLogin' => 1,
            'password' => bcrypt($data['password']),
        ]);

        $newCampaign = [
          "name" => "Your very first campaign",
          "description" => "Description",
          "done" => "0",
          "user_id" => $newUser->id,
          "slug" => "your-very-first-campaign"
        ];

        $campaign = Campaign::create($newCampaign);

        $newMission = [
          "name" => "Your very first mission",
          "description" => "Description",
          "done" => "0",
          "campaign_id" => $campaign->id,
          "mission_slug" => "your-very-first-mission"
        ];

        $mission = Mission::create($newMission);

        $newObjective = [
              "name" => "Your very first objective",
              "description" => "Description",
              "done" => "0",
              "mission_id" => $mission->id,
              "objective_slug" => "your-very-first-objective"
        ];

        Objective::create($newObjective);

        return $newUser;

    }
}
