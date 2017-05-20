@extends('layouts.wrapper')
@section('content')

@if($campaign)
    <div class="main-content">
        <div class="row">
            <div class="column small-12 medium-6 large-9">
                <h1>{{ $campaign->name }}</h1>
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
            <div class="columns small-12 medium-4 large-4">
                <div class="callout">
                    @if(count($relatedMissions) !== 0 && $campaign->percent_complete !== null)
                        <div class="percent-complete text-center">
                            <div>{{ $campaign->name }} is:</div>
                            <div><strong>{{$campaign->percent_complete}}%</strong></div>
                            <div>complete</div>
                        </div>
                    @else
                        @if($campaign->percent_complete === null)
                            <strong>Now just create an objective for your new mission</strong>
                        @else
                            <strong>You have no missions in this campaign, create one now</strong>
                        @endif
                    @endif
                </div>
            </div>
            @if(!is_null($missionClosestToCompletion))
            <div class="columns small-12 medium-4 large-4 text-center">
                <div class="callout">
                    <strong>Mission Closest To Completion:<br />{{$missionClosestToCompletion->name}}</strong>
                </div>
            </div>
            @endif

            <div class="columns small-12 medium-4 large-4 text-center">
                <div class="callout">
                    <strong>You started this campaign {{ $timeSinceCreation }}</strong>
                </div>
            </div>
        </div>

        <div class="row panes">
            <div class="column small-12 medium-8 large-8">
                <div class="callout">
                    <h2>Missions</h2>

                    <ol class="objectives listing">
                        @foreach ($relatedMissions as $mission)
                            <li>
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="summary">

                                            <div class="objective-title">
                                                <a href="/campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">{{$mission->name}}</a>
                                                @if($mission->percent_complete  === 100)
                                                    <span class="awesome double maintenance-complete complete"></span>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <div class="column small-12 medium-4 large-4">
                <div class="callout">
                    <h2>Complete</h2>
                        <div id="pie"></div>
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


        <script>



        </script>



@endsection
