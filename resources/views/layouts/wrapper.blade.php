<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link href="{{{ asset('css/main.css') }}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="stylesheet" href="{{{ asset('css/font-awesome.css') }}}">
        <link rel="stylesheet" href="{{{ asset('css/select2.min.css') }}}">
        <link rel="stylesheet" href="{{{ asset('css/jquery.mCustomScrollbar.min.css') }}}">

        <script src="{{{ asset('js/jquery-2.2.4.js') }}}"></script>
        <script src="{{{ asset('js/foundation.core.js') }}} "></script>
        <!-- Foundation Reveal -->
        <script src="{{{ asset('js/foundation.util.keyboard.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.box.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.triggers.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.mediaQuery.js') }}} "></script>
        <script src="{{{ asset('js/foundation.reveal.js') }}} "></script>

        <script src="{{{ asset('js/foundation.util.motion.js') }}} "></script>


        <script src="{{{ asset('js/typed.js')}}}"></script>


        <!-- Needed for Parallax -->
        <script src="{{{ asset('js/parallax.js') }}}"></script>
        <script src="{{{ asset('js/main.js') }}}"></script>

        <script src="{{{ asset('js/d3.js') }}}"></script>
        <script src="{{{ asset('js/d3pie.js') }}}"></script>
        <script src="{{{ asset('js/isotope.js') }}}"></script>
        <script src="{{{ asset('js/select2.min.js') }}}"></script>
        <script src="{{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}}"></script>
        <script src="{{{ asset('js/snap.svg-min.js') }}}"></script>

        <script src="//js.pusher.com/4.0/pusher.min.js"></script>

        <script src="{{{ asset('js/echo.js') }}}"></script>

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-38672471-2', 'auto');
          ga('send', 'pageview');

        </script>

        <script type="text/javascript">
            if(window.location.pathname === '/') {
                var tag = document.createElement('script');
                		tag.src = 'https://www.youtube.com/player_api';
                var firstScriptTag = document.getElementsByTagName('script')[0];
                		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                var tv,
                		playerDefaults = {autoplay: 0, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, disablekb: 1, enablejsapi: 0, iv_load_policy: 3};
                var vid = [
                			{'videoId': 'R-2puqqmycM', 'startSeconds': 227, 'suggestedQuality': 'hd720'}
                		],
                		randomVid = Math.floor(Math.random() * vid.length),
                    currVid = randomVid;

                $('.hi em:last-of-type').html(vid.length);

                function onYouTubePlayerAPIReady(){
                  tv = new YT.Player('tv', {events: {'onReady': onPlayerReady, 'onStateChange': onPlayerStateChange}, playerVars: playerDefaults});
                }

                function onPlayerReady(){
                  tv.loadVideoById(vid[currVid]);
                  tv.mute();
                }

                function onPlayerStateChange(e) {
                  if (e.data === 1){
                    $('#tv').addClass('active');
                    $('.hi em:nth-of-type(2)').html(currVid + 1);
                  } else if (e.data === 2){
                    $('#tv').removeClass('active');
                    if(currVid === vid.length - 1){
                      currVid = 0;
                    } else {
                      currVid++;
                    }
                    tv.loadVideoById(vid[currVid]);
                    tv.seekTo(vid[currVid].startSeconds);
                  }
                }

                function vidRescale(){

                  var w = $(window).width()+200,
                    h = $(window).height()+200;

                  if (w/h > 16/9){
                    tv.setSize(w, w/16*9);
                    $('.tv .screen').css({'left': '0px'});
                  } else {
                    tv.setSize(h/9*16, h);
                    $('.tv .screen').css({'left': -($('.tv .screen').outerWidth()-w)/2});
                  }
                }

                $(window).on('load resize', function(){

                  vidRescale();
                });

                $('.hi span:first-of-type').on('click', function(){
                  $('#tv').toggleClass('mute');
                  $('.hi em:first-of-type').toggleClass('hidden');
                  if($('#tv').hasClass('mute')){
                    tv.mute();
                  } else {
                    tv.unMute();
                  }
                });

                $('.hi span:last-of-type').on('click', function(){
                  $('.hi em:nth-of-type(2)').html('~');
                  tv.pauseVideo();
                });
            }
        </script>


    </head>
    <body>

    <div class="page-wrapper">
			<div id="header-bar" class="@if(Request::is('/')) homepage @endif">
				<header class="header" role="banner">
            <nav>
    					<div class="title-bar @if(Request::is('/')) transparent @endif">
    						<div class="row">

                  @if(Auth::check())
    							<div class="text-left small-5 columns follow-search">
                    <form action="/follow/search" method="get">
                        <input type="text" name="find-user" id="find-user" placeholder="Find a new follower!">
                    </form>
                  </div>
                  @else
                  <div class="text-left small-5 columns main-nav nav"></div>
                  @endif

    							<div class="home-logo text-center small-2 columns">
                    @if(Auth::check())
                    <a href="/dashboard">
                    @else
                        <a href="/">
                    @endif
                        <img src="{{{ asset('images/mission-complete.png') }}}" />
                    </a>
    							</div>
    							<div class="text-right small-5 columns">
                      @if (Route::has('login'))
                        <div class="top-right nav-links-row row">
                            <div class="nav-links">
                                @if(!Auth::check())
                                <a href="{{ url('/login') }}" class="login triple fa fa-sign-in"></a>
                                @else
                                  <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <a href="#" class="logout triple fa fa-sign-out"></a>
                                  </form>
                                  @if (!str_contains(Route::current()->getUri(), 'objective'))
                                    <a class="fa fa-plus-circle triple" data-open="completed-status" aria-controls="completed-status" aria-haspopup="true"></a>
                                  @endif
                                  <a class="fa fa-tachometer triple" href="{{ url('/dashboard') }}"></a>
                                @endif
                            </div>
                        </div>
                      @endif
                    </div>
              		</div>
              	</div>
                <div class="secondary-nav hidden" style="">Lipsum</div>
            </nav>
				</header>
            </div>
            @yield('content')

        </div>

        <script type="text/javascript">
          function addFollowers(details) {
            if($('.followers').length > 0) {
              var newFollow = "<h2>" +
                  details.followedUser.name +
                  "<a href='/follow/" + details.followId.follow_id + "' class='delete-follow'>" +
                    "<span class='fa fa-remove'></span>" +
                  "</a>" +
              "</h2>";
              $('.followers').append(newFollow);
            }
          }

          $('#find-user').keyup(function(data) {
              if($(this).val() !== '') {
                  $.ajax({
                    url: '/follow/search?find-user=' + $(this).val(),
                    context: $(this)
                  }).done(function(data) {
                    var usersFound = data;
                    console.log(usersFound);
                    var userString = "<ul class='users'>";
                    usersFound.forEach(function(user) {
                       console.log(user)
                       userString += '<li data-id="' + user.id + '">' + user.name + '</li>';
                    })
                    userString += "</ul>"
                    $(this).siblings('.users').remove();
                    $(this).after(userString);
                  })
              } else {
                  $(this).siblings('.users').remove();
              }
          })

          $('body').on('click', '.users li', function() {
            $.ajax({
              url: '/follow/create?follow-id=' + $(this).data('id')
            }).done(function(data) {
              console.log(data);
              addFollowers(data);
            })
          })
        </script>

    </body>
</html>
