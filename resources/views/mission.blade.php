@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    @if($mission)
    <div class="row">
        <div class="column small-12 medium-10 large-9">
            <h1 data-step="2" data-intro="Now we're making ground, this is your first mission. The idea of a mission is to begin to give some structure to a campaign. <br />
                                        Whilst a campaign allows you to create some sort of aim, a mission allows you to start to put some structure to that campaign. So be structured with creating your missions, create a few or create many... just make sure that they deliver.
                                        Good examples of a mission are: (Where the campaign is: I want to earn more money)
                                        <ul>
                                            <li>I need to progress from my current role to a management role</li>
                                            <li>I should build an eCommerce store as a side business in my spare time</li>
                                        </ul>
                                        If you think that the strokes are still too broad then its time to tell you about your objectives.">{{ $mission->name }}</h1>
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
            <div data-step="4" data-intro="This pane shows you how your mission has progressed. Your progression is based on the completion of each objective in this mission." class="callout">
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
            <div data-step="5" data-intro="Lastly, this pane will tell you when you first created this mission, it'll give you some idea into how much work you've put into it." class="callout">
                <strong>You started this mission {{ $timeSinceCreation }}</strong>
            </div>
        </div>
    </div>

    <div data-step="6" data-intro="Here are all of the objectives in this mission, but what are objectives? Well, they're the nuts and bolts behind this super weapon. Lets take a look at them together." class="row panes">
        <div class="column small-12 medium-6 large-8">
            <div class="callout">
                <h2>Objectives</h2>

                <ol class="objectives listing">
                    @foreach ($relatedObjectives as $objective)
                        <li>
                            <div class="card">
                                <div class="card-inner">
                                    <div class="summary">

                                        <div class="objective-title">
                                            <a href="/campaign/{{$objective->Mission->Campaign->slug}}/mission/{{$objective->mission->mission_slug}}/objective/{{$objective->objective_slug}}">{{$objective->name}}</a>
                                            @if($objective->done === 1)
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
        <div class="column small-12 medium-6 large-4">
            <div class="callout">
                <h2>Completed</h2>
                <div id="pie"></div>
            </div>
        </div>
    </div>




    @else
        <h1>You cannot access this mission</h1>
    @endif
</div>
@endsection
