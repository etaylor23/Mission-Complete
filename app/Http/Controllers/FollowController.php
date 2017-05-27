<?php

namespace App\Http\Controllers;
use Auth;
use \App\User;
use \App\Follows;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('follow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        /*
        * Get a reference to the user that is being followed
        * Create the template for the current user to follow a new user
        * If the current user doesn't already follow the user then create a new follow record, otherwise just return the existing record
        * Returns: The new or existing follow record, and the matching user information for the destination user
        */
        $userInformation = User::where('id', $request->input('follow-id'))->first();
        $followRequest = array('user_id' => Auth::user()->id, 'description' => 'NIL', 'follow_id' => $request->input('follow-id'));
        $followId = Follows::firstOrCreate($followRequest);
        return array('followId' => $followId, 'followedUser' => $userInformation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        /*
        * Remove the follow instance
        * Returns: the id of the follow instance to delete
        */
        $followInstance = Follows
                            ::where('id', $id)
                            ->first();

        $destroyedFollowInstance = $followInstance->delete();
        return $id;
    }

    public function searchUser(Request $request)
    {
        /*
        * Find all matching users where the incoming substring exists
        * Returns: an array of all matching users
        */
        $matchingUsers = User
                          ::where('name', 'LIKE', '%'.$request->input('find-user').'%')
                          ->get();
        return $matchingUsers;

    }

    public function showFollowing()
    {
      /*
      * Get all users that the currently logged in user follows
      * Returns: all users that the currently logged in user follows
      *          A dynamic page title
      *          A dynamic relationship type
      */
      $following = Auth::user()
                      ->Follows;

      return view('followList')
                ->with('following', $following)
                ->with('title', 'People You\'re Following')
                ->with('userLinkType', 'User');
    }

    public function showFollowers()
    {
      /*
      * Get all users that follow that currently logged in user
      * Returns: all users that follow that currently logged in user
      *          A dynamic page title
      *          A dynamic relationship type
      */
      $followers = Auth::user()
                      ->FollowedBy;

      return view('followList')
                ->with('following', $followers)
                ->with('title', 'Followers')
                ->with('userLinkType', 'FollowingUser');
    }
}
