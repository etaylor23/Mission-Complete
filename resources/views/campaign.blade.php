@extends('layouts.wrapper')
@section('content')

@if($campaign)
    <div class="main-content">
        <div class="row">
            <div class="column small-12 medium-6 large-9">
                <h1 data-step="2" data-intro="Okay, this is your first campaign. The idea of a campaign is to create a long term aim, this might last a couple of months or even a couple of years or more.
                                            It has to mean a lot to you, (you'll be focussing on it for a long time) but it doesn't have to be too specific. Good examples are:
                                            <ul>
                                                <li>I want to earn more money</li>
                                                <li>I want to get fitter and stronger</li>
                                            </ul>
                                            See, not too specifc - some may say that its not very measurable, its okay we'll cover the specifics in just a second.">{{ $campaign->name }}</h1>
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
                <div data-step="4" data-intro="This pane shows you how complete your campaign is, based on all of its missions and objectives." class="callout">
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
                <div data-step="5" data-intro="This area tells you your closest mission to completion, just incase you needed that extra boost to finish it." class="callout">
                    <strong>Mission Closest To Completion:<br />{{$missionClosestToCompletion->name}}</strong>
                </div>
            </div>
            @endif

            <div class="columns small-12 medium-4 large-4 text-center">
                <div data-step="6" data-intro="Lastly, this pane will tell you when you first created the campaign, it'll give you some idea into how much work you've put into it." class="callout">
                    <strong>You started this campaign {{ $timeSinceCreation }}</strong>
                </div>
            </div>
        </div>

        <div data-step="7" data-intro="Here you can see all of your missions for this campaign, lets look at a mission together right now." class="row panes">
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
