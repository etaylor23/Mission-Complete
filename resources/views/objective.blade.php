@extends('layouts.wrapper')
@section('content')

<div class="main-content">

    @include('partials.main-heading',
              array(
                'value' => $objective->name,
                'headingWidth' => null,
                'showFollowData' => null
              )
            )

    <div class="row">
        <div class="column small-11 medium-11 large-11">
            {!! Breadcrumbs::render('campaign.mission.objective.show', $campaign, $mission, $objective) !!}
        </div>
        <div class="column small-1 medium-1 large-1 delete">
            {!! Form::open(['method' => 'DELETE', 'action' => ['ObjectivesController@destroy', $campaign->slug, $mission->mission_slug, $objective->objective_slug]]) !!}
              {!! Form::submit('&#xf1f8;', ['class' => 'button full-width fa']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="columns small-12 medium-4 large-4">
            <div class="callout">
                <div class="row">
                    <div class="columns small-6 medium-6 large-6">
                        <button data-open="completed-status" type="button" name="button" class="button">Change Status</button>
                        <div class="reveal" id="completed-status" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
                          <h1>Completion Status:</h1>
                          @if($objective->done !== 1)
                              {!! Form::model($objective, ['method' => 'PUT', 'action' => ['ObjectivesController@update', $campaign->slug, $mission->mission_slug, $objective->objective_slug]]) !!}

                                  <div class="row">
                                      <div class="column">
                                          {!! Form::label('proof_of_completion', 'Proof of Completion') !!}
                                          {!! Form::textarea('proof_of_completion') !!}
                                          {!! Form::label('maintenance_plan', 'How will you maintain your progession?') !!}
                                          {!! Form::textarea('maintenance_plan') !!}
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="column small-12 medium-12 large-6">
                                          {!! Form::label('maintenance_aggression', 'How often will you carry out your maintenance? (In days)') !!}
                                          {!! Form::input('number', 'maintenance_aggression') !!}
                                      </div>
                                      <div class="column small-12 medium-12 large-6">
                                          {!! Form::label('maintenance_length', 'When will you finish maintaining your progression?') !!}
                                          {!! Form::input('date', 'maintenance_length') !!}
                                      </div>
                                  </div>
                                  {!! Form::hidden('done', 1) !!}
                                  {!! Form::submit('Complete this mission', ['class' => 'button']) !!}
                              {!! Form::close() !!}
                          @else
                              {!! Form::model($objective, ['method' => 'PUT', 'action' => ['ObjectivesController@update', $campaign->slug, $mission->mission_slug, $objective->objective_slug]]) !!}

                                  <div class="row">
                                      <div class="column">
                                          {!! Form::label('proof_of_completion', 'Proof of Completion') !!}
                                          {!! Form::textarea('proof_of_completion', null, ['disabled']) !!}
                                          {!! Form::label('maintenance_plan', 'How will you maintain your progession?') !!}
                                          {!! Form::textarea('maintenance_plan', null, ['disabled']) !!}
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="column small-12 medium-12 large-6">
                                          {!! Form::label('maintenance_aggression', 'How often will you carry out your maintenance? (In days)') !!}
                                          {!! Form::input('number', 'maintenance_aggression', null, ['disabled']) !!}
                                      </div>
                                      <div class="column small-12 medium-12 large-6">
                                          {!! Form::label('maintenance_length', 'When will you finish maintaining your progression?') !!}
                                          {!! Form::input('date', 'maintenance_length', null, ['disabled']) !!}
                                      </div>
                                  </div>
                                  {!! Form::hidden('done', 0) !!}
                                  {!! Form::submit('Incomplete this mission', ['class' => 'button']) !!}
                              {!! Form::close() !!}
                          @endif

                          <button class="close-button" data-close aria-label="Close modal" type="button">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns small-12 medium-4 large-4 text-center">
            <div class="callout">
                FREE BLOCK
            </div>
        </div>
        <div class="columns small-12 medium-4 large-4 text-center">
            <div class="callout">
                You created this objective {{ $timeSinceCreation }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column small-12 medium-12 large-12">
            <div class="callout">
                <h2>{{ $objective->name }}</h2>
                <p>{{ $objective->description }}</p>
            </div>
        </div>
    </div>

    <div class="row posts portfolioContainer">
    @foreach ($threads as $thread)
        <div class="chat objects tests columns large-3 medium-4 small-12" data-thread-id="{{$thread->id}}">
            <div class="chat-title">
                <h1>{{ $thread->User->name }}</h1>
                <h2>Is asking about {{ $thread->Post->PostSkill->first()->Skill->skill_name }}</h2>
                <figure class="avatar">
                    <img src="@if(!is_null($thread->User->image))
                                {{{ asset('images/profiles/'.$thread->User->image) }}}
                              @else
                                {{{ asset('images/profiles/wine.jpg') }}}
                              @endif
                    "/>
                </figure>
            </div>
            <div class="messages">
                <div class="messages-content">
                @foreach ($thread->message as $message)
                    <div class="message
                    @if($message->user_id === Auth::user()->id)
                      message-personal
                    @endif">
                        <figure class="avatar">
                          <img src="
                          @if($message->user_id === Auth::user()->id)
                            {{{ asset('images/profiles/'.Auth::user()->image) }}}
                          @elseif(!is_null($thread->User->image))
                            {{{ asset('images/profiles/'.$message->User->image) }}}
                          @else
                            {{{ asset('images/profiles/wine.jpg') }}}
                          @endif
                          ">
                        </figure>
                        {{ $message->message }}
                    </div>
                @endforeach
                </div>
            </div>
            <div class="message-box">
                  {!! Form::open(["action" => "ChatsController@sendMessage", "class"=>"row"]) !!}
                        <div class="column small-12 medium-12 large-12 thread-container" data-thread-id="{{$thread->id}}">
                            {!! Form::textarea("message", null, ["class" => "message-input", "placeholder" => "Type message..."]) !!}
                        </div>

                        <div class="column small-12 medium-4 large-4">
                            {!! Form::hidden('thread', $thread->id) !!}
                            {!! Form::submit("Send!", ["class" => "button submit message-submit"]) !!}
                        </div>
                  {!! Form::close() !!}
            </div>
        </div>
    @endforeach
    </div>

    <script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        // key: '4eb1e04947d0e9832e22'
        key: "{{ env('PUSHER_KEY') }}"
    });

    window.currentUserThreads = [
        @foreach ($threads as $thread)
            "{{ $thread->id }}",
        @endforeach
    ]

    currentUserThreads.forEach(function(thread) {
        Echo.channel('thread.' + thread)
        .listen('MessageSent', function(e) {
          $('.portfolioContainer')
          .children('[data-thread-id*="' + e.message.thread_id + '"]')
          .find('.messages-content')
          .append('<div class="message new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg"></figure>' + e.message.message + '</div>');
        });
    })
    </script>

</div>
@endsection
