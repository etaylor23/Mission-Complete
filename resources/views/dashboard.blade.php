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
                            </div>
                            <div class="completeness">
                                @if(!is_null($campaign->percent_complete))

                                <div id="{{ $campaign->slug }}"  class="counter-container">

                                </div>
                                <div class="end">
                                    {{ $campaign->percent_complete }}
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
        <div class="column small-12 medium-9 large-9 missions">
            <div class="row">
                <div class="column small-12 medium-12 large-12">
                    <h2>Missions</h2>
                </div>
                @if(count($missions) !== 0)
                @foreach($missions as $missionsInstance)
                    @foreach($missionsInstance as $mission)
                        <div class="column small-12 medium-12 large-6">
                            <div class="inner-column" counter parent="{{ $mission->Campaign->slug }}">
                                <div class="title">
                                    <a href="campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">
                                      {{$mission->name}}
                                    </a>
                                </div>
                                <div class="listing-wrapper hidden">
                                    <ol class="objectives listing">
                                        @foreach($mission->Objective
                                                          ->where('done', 1)
                                                          ->where('next_maintenance_instance_date', '<=', $nextMaintenceInstanceDate)
                                                          as $objective)
                                            <li class="alert @if($objective->next_maintenance_instance_date < $nextMaintenceInstanceDate) overdue @endif">
                                                <div class="card">
                                                    <div class="card-inner">
                                                        <div class="summary">
                                                            {!! Form::open(['method' => 'PUT', 'action' => ['DashboardController@maintenanceComplete', $objective->objective_slug], 'class'=>'row maintenance-complete-form']) !!}
                                                                {!! Form::submit('&#xf058;', ['class' => 'awesome double maintenance-complete']) !!}
                                                            {!! Form::close() !!}
                                                            <div class="objective-title">
                                                                <a href="/campaign/{{$objective->Mission->Campaign->slug}}/mission/{{$objective->Mission->mission_slug}}/objective/{{$objective->objective_slug}}">{{$objective->name}}</a>
                                                                <div class="fa-exclamation-circle fa"></div>
                                                            </div>
                                                            <div class="plan">
                                                                {{ date("l d F Y", strtotime($objective->next_maintenance_instance_date)) }}
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                                <div class="completeness">
                                    @if(!is_null($mission->percent_complete))
                                        <div id="{{ $mission->mission_slug }}"  class="counter-container">

                                        </div>
                                        <div class="end">
                                            {{ $mission->percent_complete }}
                                        </div>
                                    @else
                                        <span class="start">Start mission</start>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                @else
                    <strong>You have no missions</strong>
                @endif


            </div>
        </div>
    </div>


    <!-- See unsaved doc for followPosts -->
    <!-- Removed all 4 old tables, regenerating new model names correctly Posts -> Post. Need to work out why migration wont recreate, where is it stored?
        Old files on desktop -->

</div>

@endsection
