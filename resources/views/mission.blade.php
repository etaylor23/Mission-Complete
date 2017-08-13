@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    @if($mission)
    <div class="row">
        <div class="column small-12 medium-10 large-9">
            <h1>{{ $mission->name }}</h1>
            <div class="reveal" id="completed-status" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
                <div class="row">
                        {!! Form::open(['action' => 'ObjectivesController@store', 'class' => 'row']) !!}
                            <div class="column small-12 medium-12 large-12">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name') !!}
                            </div>
                            <div class="column small-12 medium-12 large-12">
                                {!! Form::label('description', 'About this mission') !!}
                                {!! Form::textarea('description', null, ['size' => '30x5']) !!}
                            </div>
                            <div class="column small-12 medium-12 large-12">
                                <p>Create as completed mission?</p>
                            </div>
                            <div class="column small-12 medium-1 large-1">
                                {!! Form::label('done', 'Yes') !!}
                                {!! Form::radio('done', '1', true) !!}
                            </div>
                            <div class="column small-12 medium-1 large-1">
                                {!! Form::label('done', 'No') !!}
                                {!! Form::radio('done', '0', true) !!}
                            </div>

                            <div class="column small-12 medium-4 large-4">
                                {!! Form::submit('Create new objective', ['class' => 'button']) !!}
                            </div>
                        {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column small-11 medium-11 large-11">
            {!! Breadcrumbs::render('campaign.mission.show', $campaign, $mission) !!}
        </div>
        <div class="column small-1 medium-1 large-1 delete">
            {!! Form::open(['method' => 'DELETE', 'action' => ['MissionsContoller@destroy', $campaign->slug, $mission->mission_slug]]) !!}
              {!! Form::submit('&#xf1f8;', ['class' => 'button full-width fa']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row">

        <div class="columns small-12 medium-6 large-6">
            <div class="callout">
                @if(count($relatedObjectives) === 0)
                    <strong>You have no objectives in this mission, create one now</strong>
                @else
                    <div class="percent-complete text-center">
                        <div>{{ $mission->name }} is:</div>
                        <div><strong>{{ $mission->percent_complete }}%</strong></div>
                        <div>complete</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="columns small-12 medium-6 large-6 text-center">
            <div class="callout">
                <strong>You started this mission {{ $timeSinceCreation }}</strong>
            </div>
        </div>
    </div>

    <div class="row panes">
        <div class="column small-12 medium-6 large-8">
            <h2>Objectives</h2>
            <div class="row missions panes">
            		<div class="grid-sizer"></div>
            		<div class="grid-item"></div>
            		@foreach ($relatedObjectives as $objective)
            			@include('partials.pane',
            								array(
            									'pane' => $objective,
                              'url' => '/campaign/'.$objective->Mission->Campaign->slug.'/mission/'.$objective->mission->mission_slug.'/objective/'.$objective->objective_slug,
            									'containerClasses' => "mission",
                              'showObjectives' => false,
                              'parentAttribute' => 'NA',
                              'completeness' => false
            								)
            							)
            		@endforeach
            </div>
        </div>
        <div class="column small-12 medium-6 large-4">
            <div class="callout">
                <h2>Completed</h2>
                <div class="panes">
                    <div class="container">
                        <div class="svg-pie-percent" id="campaignPercent"></div>
                        <svg id="pieSVG"></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>




    @else
        <h1>You cannot access this mission</h1>
    @endif
</div>
@endsection
