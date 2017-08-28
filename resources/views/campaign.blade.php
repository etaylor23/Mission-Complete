@extends('layouts.wrapper')
@section('content')

@if($campaign)
    <div class="main-content">
        @include('partials.main-heading',
                  array(
                    'value' => $campaign->name,
                    'headingWidth' => null,
                    'showFollowData' => null
                  )
                )
        <div class="row">
            <div class="column small-12 medium-6 large-9">
                <div class="reveal" id="completed-status" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
                    <div class="row">
                          {!! Form::open(['action' => 'MissionsContoller@store', 'class' => 'row']) !!}
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name') !!}
                                </div>
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('description', 'About this mission') !!}
                                    {!! Form::textarea('description', null, ['size' => '30x5']) !!}
                                </div>

                                {!! Form::hidden('done', '0') !!}

                                <div class="column small-12 medium-4 large-4">
                                    {!! Form::submit('Create new mission', ['class' => 'button']) !!}
                                </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="column small-11 medium-11 large-11">
                {!! Breadcrumbs::render('campaign.show', $campaign) !!}
            </div>
            <div class="column small-1 medium-1 large-1 delete">
                {!! Form::open(['method' => 'DELETE', 'action' => ['CampaignsController@destroy', $campaign->slug]]) !!}
                  {!! Form::submit('&#xf1f8;', ['class' => 'button full-width fa']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">

        </div>

        <div class="row">
            <div class="small-8 medium-8 large-8 column">
              <h2>Progress</h2>
            </div>
            <div class="small-4 medium-4 large-4 column">
              <h2>Summary</h2>

            </div>
        </div>
        <div class="row">
            <div class="column small-12 medium-8 large-8">
                <div class="row missions panes">
                		<div class="grid-sizer"></div>
                		<div class="grid-item"></div>
                		@foreach ($relatedMissions as $pane)
                			@include('partials.pane',
                								array(
                									'pane' => $pane,
                									'url' => '/campaign/'.$pane->Campaign->slug.'/mission/'.$pane->mission_slug,
                									'containerClasses' => "mission ".$pane->Campaign->slug,
                                  'showObjectives' => false,
                                  'parentAttribute' => $pane->Campaign->slug,
                                  'completeness' => true
                								)
                							)
                		@endforeach
                </div>
            </div>

            <div class="column small-12 medium-4 large-4">
                <div class="inner-column">
                  <h2 class="title">Complete</h2>
                  <div>
                    <div class="container">
                      <div class="svg-pie-percent" id="campaignPercent"></div>
                      <svg id="pieSVG"></svg>
                    </div>
                  </div>
                </div>
                @if(!is_null($missionClosestToCompletion))
                  <div class="inner-column text-center small">
                    <strong>Mission Closest To Completion:<br />{{$missionClosestToCompletion->name}}</strong>
                  </div>
                @endif
                <div class="inner-column text-center small">
                  <strong>You started this campaign {{ $timeSinceCreation }}</strong>
                </div>

            </div>
        </div>

        <div class="row tree-container">
            <div class="column small-12 medium-12 large-12">
                <div class="callout">
                    <div class="callout-inner tree">

                    </div>
                </div>
            </div>

        </div>
    @else
        <h1>You cannot access this campaign</h1>
    @endif

    </div>


        <style>

        .node {
          cursor: pointer;
        }

        .node circle {
          fill: #fff;
          stroke: rgb(23, 55, 1);
          stroke-width: 1.5px;
        }

        .node text {
          font-size: 1rem;
        }

        .link {
          fill: none;
          stroke: #ccc;
          stroke-width: 3.5px;
        }

        </style>

@endsection
