@extends('layouts.wrapper')
@section('content')

<div class="main-content">

    @include('partials.main-heading',
              array(
                'value' => 'Your Dashboard',
                'headingWidth' => 'small-12 medium-9 large-9',
                'showFollowData' => array(
                    'follow' => $following,
                    'followers' => $followers
                )
              )
            )

    <div class="row">

{{-- <h1 class="elegantshadow">Your Dashboard</h1>
<h1 class="deepshadow">Deep Shadow</h1>
<h1 class="insetshadow">Inset Shadow</h1>
<h1 class="retroshadow">Retro Shadow</h1> --}}


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
                                <a data-filter=".{{ $campaign->slug }}"class="campaign-filter fa-filter fa"></a>
                            </div>
                            <div class="completeness">
                                @if(!is_null($campaign->percent_complete))

                                <div id="{{ $campaign->slug }}"  class="counter-container">

                                </div>
                                <div class="end">
                                    {{ $campaign->percent_complete }}
                                </div>

                                <div class="container">
                                  <div id="percent"></div>
                                  <svg id="svg-{{ $campaign->id }}"></svg>
                                </div>
                                @else
                                    <span class="start"><a href="/campaign/{{ $campaign->slug }}">Start Campaign</a>
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
        <div class="column small-12 medium-9 large-9">
            <div class="row">
                <div class="column small-12 medium-6 large-6">
                    <h2>Missions</h2>
                </div>
            </div>

            <div class="row missions">
                <div class="grid-sizer"></div>
                <div class="grid-item"></div>
                @foreach($missions as $missionInstanceKey => $missionsInstance)
                    @foreach($missionsInstance as $missionKey => $pane)
                        @include('partials.pane',
                                  array(
                                    'pane' => $pane,
                                    'url' => '/campaign/'.$pane->Campaign->slug.'/mission/'.$pane->mission_slug,
                                    'containerClasses' => "mission ".$pane->Campaign->slug,
                                    'showObjectives' => true,
                                    'parentAttribute' => $pane->Campaign->slug,
                                    'completeness' => true
                                  )
                                )
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

</div>

<div class="reveal" id="dashboard-intro-video" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/tXQneqLJbmI" frameborder="0" allowfullscreen></iframe>
    {!! Form::open(['method' => 'POST', 'action' => ['DashboardController@tutorials']]) !!}
        {!! Form::hidden('no-tutorials', '0') !!}
        {!! Form::submit('Don\'t show me tutorials', ['class' => 'button']) !!}
    {!! Form::close() !!}
</div>

<script type="text/javascript">
    window.firstLogin = "{{ $firstLogin }}";
</script>

@endsection
