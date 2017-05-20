@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    <div class="row">
        <div class="column small-12 medium-10 large-10">
            <h1>{{ $objective->name }}</h1>
        </div>
    </div>

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





</div>
@endsection
