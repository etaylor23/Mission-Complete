@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    <div class="row">
        <h1 class="column small-11 medium-11 large-11">Your Dashboard</h1>

            <div class="reveal" id="completed-status" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
                <div class="row">
                    <div class="large-12 columns">
                          @if(!$campaigns->isEmpty())
                              <h2>Create a new campaign</h2>
                          @else
                              <h2>Create your first campaign</h2>
                              <a href="#">Or get a tour</a>
                          @endif
                          {!! Form::open(['action' => 'CampaignsController@store', 'class'=>'row']) !!}
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::select('name', array('S' => '---- Select Campaign ----', 'Career' => 'Career', 'Education' => 'Education')) !!}
                                </div>
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('description', 'About this campaign') !!}
                                    {!! Form::textarea('description', null, ['size' => '30x5']) !!}
                                </div>

                                    {!! Form::hidden('done', '0') !!}
                                <div class="column small-12 medium-4 large-4">
                                    {!! Form::submit('Create new campaign', ['class' => 'button']) !!}
                                </div>
                            {!! Form::close() !!}
                    </div>
                </div>

              <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            {!! Breadcrumbs::render('dashboard') !!}
        </div>
    </div>


    <div class="row panes">
        <div class="column small-12 medium-3 large-3 campaigns">
            <div class="row">
                <div class="column small-12 medium-12 large-12">
                    <h2>Campaigns</h2>
                </div>
                @if(!$campaigns->isEmpty())
                    @foreach ($campaigns as $campaign)
                    <div class="column small-12 medium-12 large-12">
                        <div class="inner-column" counter top="{{ $campaign->slug }}">
                            <div class="title">
                                <a href="/campaign/{{ $campaign->slug }}">{{ $campaign->name }}</a>
                                <a data-filter=".{{ $campaign->slug }}"class="campaign-filter fa-filter fa"></a>
                            </div>
                            <div class="completeness">
                                @if(!is_null($campaign->percent_complete))

                                <div id="{{ $campaign->slug }}"  class="counter-container">

                                </div>
                                <div class="end">
                                    {{ $campaign->percent_complete }}
                                </div>

                                <div class="container">
                                  <div id="percent"></div>
                                  <svg id="svg-{{ $campaign->id }}"></svg>
                                </div>
                                @else
                                    <span class="start">Start campaign</start>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <strong>You have no open campaigns</strong>
                @endif
            </div>
        </div>
        <div class="column small-12 medium-9 large-9">
            <div class="row">
                <div class="column small-12 medium-6 large-6">
                    <h2>Missions</h2>
                </div>
                <div class="column small-12 medium-3 large-3">
                    <a href="/follow/following">
                        <h2>Following: {{ $following }}</h2>
                    </a>
                </div>
                <div class="column small-12 medium-3 large-3">
                    <a href="/follow/followers">
                    <h2>Followers: {{ $followers }}</h2>
                  </a>
                </div>
            </div>

            <div class="row missions">
                <div class="grid-sizer"></div>
                <div class="grid-item"></div>
                @foreach($missions as $missionInstanceKey => $missionsInstance)
                    @foreach($missionsInstance as $missionKey => $pane)
                        @include('partials.pane',
                                  array(
                                    'pane' => $pane,
                                    'url' => '/campaign/'.$pane->Campaign->slug.'/mission/'.$pane->mission_slug,
                                    'containerClasses' => "mission ".$pane->Campaign->slug,
                                    'showObjectives' => true,
                                    'parentAttribute' => $pane->Campaign->slug,
                                    'completeness' => true
                                  )
                                )
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <div class="posts">
        <div class="portfolioFilter row">
            <a href="#" data-filter="*" class="current">
              #AllCategories
            </a>
            @foreach($currentUserSkillsName as $skillName => $skillValue)
                <a href="#" data-filter=".{{ $skillValue }}">
                    #{{ $skillValue }}
                </a>
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
            // key: '4eb1e04947d0e9832e22'
            key: "{{ env('PUSHER_KEY') }}"
        });

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

        window.userid = "{{ $userId }}";
        window.csrf = "{{ csrf_token() }}";
        
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

</div>

@endsection
