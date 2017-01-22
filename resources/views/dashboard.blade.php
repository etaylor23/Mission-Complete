@extends('layouts.wrapper')
@section('content')

<div class="main-content">
    <div class="row">
        <h1 class="column small-11 medium-11 large-11">Your Dashboard</h1>

            <div class="reveal" id="completed-status" data-reveal>
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
                                    {!! Form::text('name') !!}
                                </div>
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('description', 'About this mission') !!}
                                    {!! Form::textarea('description', null, ['size' => '30x5']) !!}
                                </div>
                                <div class="column small-12 medium-12 large-12">
                                    <p>Create as a completed campaign?</p>
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
    <div class="row">
        <div class="column small-12 medium-6 large-6">
            <div data-step="2" data-intro="These are your open campaigns, they're open because they contain incomplete missions for you to finish." class="callout">
                <h2 class="">Open Campaigns</h2>
                @if(!$campaigns->isEmpty())
                <ul class="campaigns listing">
                    @foreach ($campaigns as $campaign)
                        @if($campaign->percent_complete !== 100)
                            <li>
                                <div class="card">
                                    <div class="summary">
                                        <a href="{{ action('CampaignsController@showCampaign', [$campaign->slug]) }}">{{ $campaign->name }}</a>
                                        <strong>@if(!is_null($campaign->percent_complete))({{ $campaign->percent_complete }}%)@endif</strong>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @else
                    <strong>You have no open campaigns</strong>
                @endif
          </div>
      </div>

        <div class="column small-12 medium-6 large-6">
          <div data-step="3" data-intro="These are your open missions, these guys are open because they have incomplete objectives within them, we'll cover what campaigns, missions and objectives actually are in just a second."  class="callout">
              <h2>Open Missions</h2>
              @if(count($missions) !== 0)
                  <ul class="missions listing">
                      @foreach($missions as $missionsInstance)
                          @foreach($missionsInstance as $mission)
                              @if($mission->percent_complete !== 100)
                                  <li>
                                      <div class="card">
                                          <div class="summary">

                                            <a href="campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">
                                              {{$mission->name}}
                                            </a>
                                            <strong>@if(!is_null($mission->percent_complete))({{ $mission->percent_complete }}% - {{$mission->Campaign->name}})@endif</strong>

                                          </div>
                                      </div>
                                  </li>

                                  @foreach($mission->Objective
                                                    ->where('done', 1)
                                                    ->where('next_maintenance_instance_date', '<=', $nextMaintenceInstanceDate)
                                                    as $objective)
                                      <li class="alert @if($objective->next_maintenance_instance_date < $nextMaintenceInstanceDate) overdue @endif">
                                          <div class="card">
                                              <div class="summary">
                                                  <a class="white" href="/campaign/{{$objective->Mission->Campaign->slug}}/mission/{{$objective->Mission->mission_slug}}/objective/{{$objective->objective_slug}}">
                                                      {{$objective->name}}
                                                  </a>
                                                  <span class="expand fa fa-plus-circle"></span>
                                                  <div class="plan hidden">
                                                      <div class="plan-inner">
                                                            <div>{{$objective->maintenance_plan}}</div>
                                                            <div>
                                                                <strong>Next Maintenance Date: </strong>{{ date("l d F Y", strtotime($objective->next_maintenance_instance_date)) }}
                                                            </div>

                                                            {!! Form::open(['method' => 'PUT', 'action' => ['DashboardController@maintenanceComplete', $objective->objective_slug], 'class'=>'row']) !!}
                                                                {!! Form::submit('&#xf058;', ['class' => 'button awesome double maintenance-complete']) !!}
                                                            {!! Form::close() !!}
                                                     </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </li>
                                  @endforeach
                              @endif
                          @endforeach
                      @endforeach
                  </ul>
              @else
                  <strong>You have no open missions</strong>
              @endif
          </div>
      </div>
    </div>

    <div class="row">
        <div class="column small-12 medium-6 large-6">
            <div data-step="4" data-intro="These are completed campaigns, campaigns will show as complete when all of their elements are 100% completed. Don't expect to see anything hear for a while, campaigns take a long time to complete." class="callout">
                <h2>Completed Campigns</h2>
                @if(!$campaigns->isEmpty())
                    <ul class="completed-campaigns listing">
                      @foreach ($campaigns as $campaign)
                          @if($campaign->percent_complete === 100)
                              <li>
                                  <div class="card">
                                      <div class="summary">
                                          <a href="{{ action('CampaignsController@showCampaign', [$campaign->slug]) }}">{{ $campaign->name }}</a>

                                          <strong>@if(!is_null($campaign->percent_complete))({{ $campaign->percent_complete }}%)@endif</strong>
                                      </div>
                                  </div>
                              </li>
                          @endif
                      @endforeach
                    </ul>
                @else
                    <strong>You have no completed campaigns</strong>
                @endif
            </div>
        </div>

        <div class="column small-12 medium-6 large-6">
            <div data-step="5" data-intro="Finally, these are your completed missions, they will show as completed when all of that mission's objectives are completed" class="callout">
                <h2>Completed Missions</h2>

                @if(count($missions) !== 0)
                    <ul class="missions listing">
                        @foreach($missions as $missionsInstance)
                            @foreach($missionsInstance as $mission)
                                @if($mission->percent_complete === 100)
                                    <li>
                                        <div class="card">
                                            <div class="summary">

                                              <a href="campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">
                                                {{$mission->name}}
                                              </a>
                                              <strong>@if(!is_null($mission->percent_complete))({{ $mission->percent_complete }}% - {{$mission->Campaign->name}})@endif</strong>

                                            </div>
                                        </div>
                                    </li>

                                    @foreach($mission->Objective
                                                      ->where('done', 1)
                                                      ->where('next_maintenance_instance_date', '<=', $nextMaintenceInstanceDate)
                                                      as $objective)
                                        <li class="alert @if($objective->next_maintenance_instance_date < $nextMaintenceInstanceDate) overdue @endif">
                                            <div class="card">
                                                <div class="card-inner">
                                                    <div class="summary">
                                                        <a class="white" href="/campaign/{{$objective->Mission->Campaign->slug}}/mission/{{$objective->Mission->mission_slug}}/objective/{{$objective->objective_slug}}">
                                                            {{$objective->name}}
                                                        </a>
                                                        <span class="expand fa fa-plus-circle"></span>
                                                        <div class="plan hidden">
                                                            <div class="plan-inner">
                                                                <div>{{$objective->maintenance_plan}}</div>
                                                                <div>
                                                                    <strong>Next Maintenance Date: </strong>{{ date("l d F Y", strtotime($objective->next_maintenance_instance_date)) }}
                                                                </div>
                                                                {!! Form::open(['method' => 'PUT', 'action' => ['DashboardController@maintenanceComplete', $objective->objective_slug], 'class'=>'row']) !!}
                                                                    {!! Form::submit('&#xf058;', ['class' => 'button awesome double maintenance-complete']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                @else
                    <strong>You have no open missions</strong>
                @endif



            </div>
        </div>
    </div>

</div>

@endsection
