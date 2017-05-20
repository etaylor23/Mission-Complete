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

    <div class="posts">



        <div class="portfolioFilter row">
            <a href="#" data-filter="*" class="current">
              #AllCategories
            </a>
            @foreach($currentUserSkillsName as $skillName => $skillValue)
                <a href="#" data-filter=".{{ $skillValue }}">
                    #{{ $skillValue }}
                </a>
            @endforeach

        	<!-- <a href="#" data-filter=".people">People</a>
        	<a href="#" data-filter=".places">Places</a>
        	<a href="#" data-filter=".food">Food</a>
            <a href="#" data-filter=".objects">Objects</a>
            <a href="#" data-filter=".tests">Tests</a> -->

        </div>

        <div class="portfolioContainer row posts">

            @foreach($followPosts->Follows as $followed => $followedValue)
                @foreach ($followedValue->User->Posts as $post => $postValue)
                    <?php
                      $a=array("67DB88", "7CCB93", "4D9E69");
                      $random_keys=array_rand($a,1);
                    ?>
                    <div style="background-color: #<?php echo $a[$random_keys] ?>;" class="objects tests columns large-3
                    @foreach ($postValue->PostSkill as $postSkill => $postSkillValue)
                        {{ $postSkillValue->Skill->skill_name }}
                    @endforeach
                    ">
                        <div class="post-inner">
                            <h3>{{ $followedValue->User->name }}</h3>
                            {{ $postValue->post_content }}<br />
                            You also have
                            @foreach ($postValue->PostSkill as $postSkill => $postSkillValue)
                              {{ $postSkillValue->Skill->skill_name }} |
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endforeach


        	<!-- <div class="objects columns large-3">
        		<img src="images/images/watch.jpg" alt="image">
        	</div>

        	<div class="people places columns large-3">
        		<img src="images/images/surf.jpg" alt="image">
        	</div>

        	<div class="food columns large-3">
        		<img src="images/images/burger.jpg" alt="image">
        	</div>

        	<div class="people places columns large-3">
        		<img src="images/images/subway.jpg" alt="image">
        	</div>

        	<div class="places objects columns large-3">
        		<img src="images/images/trees.jpg" alt="image">
        	</div>

        	<div class="people food objects columns large-3">
        		<img src="images/images/coffee.jpg" alt="image">
        	</div>

        	<div class="food objects columns large-3">
        		<img src="images/images/wine.jpg" alt="image">
        	</div>

        	<div class="food columns large-3">
        		<img src="images/images/salad.jpg" alt="image">
        	</div> -->

        </div>
    </div>

    <script type="text/javascript">

    $(window).load(function(){
        var $container = $('.portfolioContainer');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        $('.portfolioFilter a').click(function(){
            $('.portfolioFilter .current').removeClass('current');
            $(this).addClass('current');

            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
             });
             return false;
        });
    });

    </script>

    <script type="text/javascript">

        window.Echo = new Echo({
            broadcaster: 'pusher',
            // key: '4eb1e04947d0e9832e22'
            key: "{{ env('PUSHER_KEY') }}"
        });

        /*
        * Add the current user's skills to an array
        * For each of the current user's skills:
        * - Create an Echo channel using the skill and the current user's id
        * - Listen on 'ObjectiveComplete'
        * - Add an isotope container to the view when the web socket sends new data
        */
        window.currentUserSkills = [
          @foreach($currentUserSkillsName as $skillName => $skillValue)
            "{{ $skillValue }}",
          @endforeach
        ];

        currentUserSkills.forEach(function(skill) {
          Echo.channel('chat-room.' + skill + '.' + {{ $userId }})
          .listen('ObjectiveComplete', function(e) {
            var test = $('<div class="objects tests columns large-3 ' + e.message.skill_name + '"><div class="post-inner"><h3>' + e.user.name + '</h3>' + e.message.post_content + '</div></div>');
            $('.portfolioContainer')
            .append(test)
            .isotope('appended', test);
          });
        })

    </script>

</div>

@endsection
