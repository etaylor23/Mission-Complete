@extends('layouts.wrapper')
@section('content')

	<div class="posts">
			<div class="portfolioFilter row">
					<div class="wrapper">
							<a class="fourth before after" href="#" data-filter="*">#AllCategories</a>
					</div>
					@foreach($currentUserSkillsName as $skillName => $skillValue)
							<div class="wrapper">
							    <a class="fourth before after" href="#" data-filter=".{{ $skillValue }}">#{{ $skillValue }}</a>
							</div>
					@endforeach
			</div>

			<div class="portfolioContainer row posts">
					@foreach($followPosts->Follows as $followed => $followedValue)
							@foreach ($followedValue->User->Posts as $post => $postValue)
									<div
											data-thread-id=
												"@if(!is_null($postValue->ThreadAll))
														@if(!$postValue->ThreadAll->where('user_id', Auth::user()->id)->isEmpty())
																{{ $postValue->ThreadAll->where('user_id', Auth::user()->id)->first()->id }}
														@else
																0
														@endif
												@else
														0
												@endif"
											data-post-id="{{ $postValue->id }}"
											class="chat objects tests columns large-3
											@foreach ($postValue->PostSkill as $postSkill => $postSkillValue)
												{{ $postSkillValue->Skill->skill_name }}
											@endforeach">
													<div class="chat-title">
															<h1>{{ $followedValue->User->name }}</h1>
															<h2>just completed {{ $postValue->post_content }}</h2>
															<figure class="avatar">
																	<img src="
																			@if(!is_null($followedValue->User->image))
																				{{{ asset('images/profiles/'.$followedValue->User->image) }}}
																			@else
																				{{{ asset('images/profiles/wine.jpg') }}}
																			@endif
																	" />
															</figure>
													</div>
										<div class="chat-title">
												<h2>
														Talk to them about @foreach ($postValue->PostSkill as $postSkill => $postSkillValue)
													{{ $postSkillValue->Skill->skill_name }}
												@endforeach
												</h2>
										</div>

										<div class="messages">
												<div class="messages-content">
														@if($postValue->Thread)
																@if($postValue->Thread->where([['post_id', '=', $postValue->id], ['user_id', '=', Auth::user()->id]])->first())
																			@foreach ($postValue->Thread->where([['post_id', '=', $postValue->id], ['user_id', '=', Auth::user()->id]])->first()->Message as $message => $messageValue)
																					<div class="message
																							@if($messageValue->user_id === Auth::user()->id)
																								message-personal
																							@endif">
																							<figure class="avatar">
																								<img src="
																										@if($messageValue->user_id === Auth::user()->id)
																											{{{ asset('images/profiles/'.Auth::user()->image) }}}
																										@elseif(!is_null($messageValue->User->image))
																											{{{ asset('images/profiles/'.$messageValue->User->image) }}}
																										@else
																											{{{ asset('images/profiles/wine.jpg') }}}
																										@endif
																								">
																							</figure>
																							{{ $messageValue->message }}
																					</div>
																			@endforeach
																@endif
														@endif
												</div>
										</div>
										<div class="message-box">
												{!! Form::open(["action" => "ChatsController@sendMessage"]) !!}
																	{!! Form::textarea("message", null, ["class" => "message-input", "placeholder" => "Type message..."]) !!}
																	@if(!is_null($postValue->ThreadAll))
																			@if(!$postValue->ThreadAll->where('user_id', Auth::user()->id)->isEmpty())
																				{!! Form::hidden('thread', $postValue->ThreadAll->where('user_id', Auth::user()->id)->first()->id) !!}
																			@else
																					{!! Form::hidden('thread', 0) !!}
																			@endif
																	@else
																			{!! Form::hidden('thread', 0) !!}
																	@endif
																	{!! Form::hidden('post', $postValue->id) !!}
																	{!! Form::submit("Send!", ["class" => "button submit message-submit"]) !!}
													{!! Form::close() !!}
										</div>
									</div>
							@endforeach
					@endforeach
			</div>
	</div>

	<script type="text/javascript">
			window.Echo = new Echo({
					broadcaster: 'pusher',
<<<<<<< HEAD
=======
					// key: '4eb1e04947d0e9832e22'
>>>>>>> 1ca2391bb55cfdf86ebe5159a4a416431acd6432
					key: "{{ env('PUSHER_KEY') }}"
			});

			window.userid = "{{ $userId }}";
			window.csrf = "{{ csrf_token() }}";

			/*
			* Add the current user's skills to an array
			* For each of the current user's skills:
			* - Create an Echo channel using the skill and the current user's id
			* - Listen on 'ObjectiveComplete'
			* - Add an isotope container to the view when the web socket sends new data
			*/
			window.currentUserSkills = [
				@foreach($currentUserSkillsName as $skillName => $skillValue)
					"{{ $skillValue }}",
				@endforeach
			];


			window.currentUserThreads = [
				@foreach($followPosts->Follows as $followed => $followedValue)
						@foreach ($followedValue->User->Posts as $post => $postValue)
								@if(!is_null($postValue->ThreadAll))
										@if(!$postValue->ThreadAll->where('user_id', Auth::user()->id)->isEmpty())
												"{{ $postValue->ThreadAll->where('user_id', Auth::user()->id)->first()->id }}",
										@endif
								@endif
						@endforeach
				@endforeach
			];

			currentUserThreads.forEach(function(thread) {
					Echo.channel('thread.' + thread)
					.listen('MessageSent', function(e) {
						$('.portfolioContainer')
						.find('[data-thread-id*="' + e.message.thread_id + '"]')
						.find('.messages-content')
						.append('<div class="message new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg"></figure>' + e.message.message + '</div>');
					});
			})
	</script>

@endsection
