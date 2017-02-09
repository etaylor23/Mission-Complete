@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    <div class="row">
        <div class="column small-12 medium-10 large-10">
            <h1 data-step="2" data-intro="You've made it, well done Soldier. This is where you come to complete your objectives.
                                            These are the small things that build up your progression within missions and campaigns.<br />
                                            Objectives are the bullets in your armoury, you can get through these fast!<br />
                                            But watch out, when you complete an objective you have to maintain it to keep it completed!">{{ $objective->name }}</h1>
        </div>
    </div>

    <div data-step="3" data-intro="This section lets you know exactly where you are, use it to traverse the playing field" class="row">
        <div class="column">
            {!! Breadcrumbs::render('campaign.mission.objective.show', $campaign, $mission, $objective) !!}
        </div>
    </div>

    <div class="row">
        <div class="columns small-12 medium-4 large-4">
            <div class="callout">
                <div class="row">
                  <div data-step="4" data-intro="Just like before, this lets you remove an objective." class="columns small-6 medium-6 large-6">
                      {!! Form::open(['method' => 'DELETE', 'action' => ['ObjectivesController@destroy', $campaign->slug, $mission->mission_slug, $objective->objective_slug]]) !!}
                        {!! Form::submit('Delete this objective', ['class' => 'button']) !!}
                      {!! Form::close() !!}
                  </div>
                    <div class="columns small-6 medium-6 large-6">

                            <button data-step="5" data-intro="Here we can mark an objective as completed, you'll have to provide some proof of completion and come up with a maintenance plan." data-open="completed-status" type="button" name="button" class="button">Change Status</button>

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
            <div data-step="6" data-intro="This tells you when you created your objective, but you already knew that." class="callout">
                You created this objective {{ $timeSinceCreation }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column small-12 medium-12 large-12">
            <div data-step="7" data-intro="This section tells you all about your objective, use it as your briefing." class="callout">
                <h2>{{ $objective->name }}</h2>
                <p>{{ $objective->description }}</p>
            </div>
        </div>
    </div>





</div>
@endsection
