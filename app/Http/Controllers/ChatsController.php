<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;


class ChatsController extends Controller
{
	public function __construct()
	{
	  $this->middleware('auth');
	}

	/**
	 * Show chats
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

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

			return view('chat')
					->with('userId', Auth::user()->id)
					->with('followPosts', $followPosts)
					->with('currentUserSkillsName', $currentUserSkillsName);
	}

	/**
	 * Fetch all messages
	 *
	 * @return Message
	 */
	public function fetchMessages()
	{
	  return Message::with('user')->get();
	}

	/**
	 * Persist message to database
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function sendMessage(Request $request)
	{
	  $user = Auth::user();

		/*
		*		On dashboard template, if a thread exists for a post the thread id is printed, if not then 0 is used
		*		If 0 is used as the thread id then no thread exists, a new one is created in the if block
		*		If a thread already exists then the else condition is used
		*		Both should create a new Message
		*		Both might be able to be merged
		*/

		if($request->input('thread') === "0") {
			$newThread = \App\Thread::create(['post_id' => $request->input('post'), 'user_id' => Auth::user()->id]);
		} else {
			$incomingPostId = $request->input('post');
			$incomingThreadId = $request->input('thread');

			$newThread = \App\Thread::firstOrCreate(
		    //'message' => $request->input('message')
					['id' => $incomingThreadId],
				 	['id' => $incomingThreadId, 'post_id' => $incomingPostId, 'user_id' => Auth::user()->id]
		  );

		}

		$message = \App\Message::create(
			['user_id' => $user->id, 'thread_id' => $newThread->id, 'message' => $request->input('message')]
		);

		// event(new MessageSent($message, $newThread, Auth::user()));
		broadcast(new MessageSent($message, $newThread, Auth::user()))->toOthers();

		return array(
			'message' => $message,
			'thread'	=> $newThread
		);

	}



}
