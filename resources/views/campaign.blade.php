@extends('layouts.wrapper')
@section('content')

@if($campaign)
    <div class="page-wrapper">
        <div class="row">
            <div class="column small-12 medium-6 large-9">
                <h1 data-step="2" data-intro="Okay, this is your first campaign. The idea of a campaign is to create a long term aim, this might last a couple of months or even a couple of years or more.
                                            It has to mean a lot to you, (you'll be focussing on it for a long time) but it doesn't have to be too specific. Good examples are:
                                            <ul>
                                                <li>I want to earn more money</li>
                                                <li>I want to get fitter and stronger</li>
                                            </ul>
                                            See, not too specifc - some may say that its not very measurable, its okay we'll cover the specifics in just a second.">{{ $campaign->name }}</h1>
                <div class="reveal" id="completed-status" data-reveal>
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
                                    {!! Form::submit('Create new mission', ['class' => 'button']) !!}
                                </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="column">
                {!! Breadcrumbs::render('campaign.show', $campaign) !!}
            </div>
        </div>
        <div class="row">
            <div class="columns small-12 medium-3 large-3">
                <div data-step="3" data-intro="Just like you can create a campaign, you can delete one if you feel that its just not you anymore. But before you do, ask yourself what's changed? <br />
                                                Did you take this task on too lightly? Was the aim slightly misplaced?" class="callout">
                    <div class="row">
                        <div class="column small-12 medium-12 large-12">
                        {!! Form::open(['method' => 'DELETE', 'action' => ['CampaignsController@destroy', $campaign->slug]]) !!}
                          {!! Form::submit('Delete this campaign', ['class' => 'button full-width']) !!}
                        {!! Form::close() !!}
                        </div>
                        @if(session('deletedMission'))
                            <div class="column small-12 medium-12 large-12">
                                <strong>{{session('deletedMission')}}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="columns small-12 medium-3 large-3">
                <div data-step="4" data-intro="This pane shows you how complete your campaign is, based on all of its missions and objectives." class="callout">
                    @if(count($relatedMissions) === 0)
                        <strong>You have no missions in this campaign, create one now</strong>
                    @else
                        <div class="percent-complete text-center">
                            <div>{{ $campaign->name }} is:</div>
                            <div><strong>{{$campaign->percent_complete}}%</strong></div>
                            <div>complete</div>
                        </div>
                    @endif
                </div>
            </div>
            @if(!is_null($missionClosestToCompletion))
            <div class="columns small-12 medium-3 large-3 text-center">
                <div data-step="5" data-intro="This area tells you your closest mission to completion, just incase you needed that extra boost to finish it." class="callout">
                    <strong>Mission Closest To Completion:<br />{{$missionClosestToCompletion->name}}</strong>
                </div>
            </div>
            @endif

            <div class="columns small-12 medium-3 large-3 text-center">
                <div data-step="6" data-intro="Lastly, this pane will tell you when you first created the campaign, it'll give you some idea into how much work you've put into it." class="callout">
                    <strong>You started this campaign {{ $timeSinceCreation }}</strong>
                </div>
            </div>
        </div>

        <div data-step="7" data-intro="Here you can see all of your missions for this campaign, lets look at a mission together right now." class="row">
            <div class="column small-12 medium-6 large-6">
                <div class="callout">
                    <h2>Open missions</h2>
                    <ul class="open-missions listing">
                        @foreach ($relatedMissions as $mission)
                            @if($mission->percent_complete  !== 100)
                            <li>
                                <div class="card">
                                    <div class="summary">
                                        <a href="/campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">{{ $mission->name }}</a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="column small-12 medium-6 large-6">
                <div class="callout">
                    <h2>Complete missions</h2>
                    <ul class="open-missions listing">
                        @foreach ($relatedMissions as $mission)
                            @if($mission->percent_complete  === 100)
                            <li>
                                <div class="card">
                                    <div class="summary">
                                        <a href="/campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">{{ $mission->name }}</a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @else
        <h1>You cannot access this campaign</h1>
    @endif

    </div>

@endsection
