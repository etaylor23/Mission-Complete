<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link href="{{{ asset('css/main.css') }}}" rel="stylesheet">
        <link href="{{{ asset('css/introjs.css') }}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="stylesheet" href="{{{ asset('css/font-awesome.css') }}}">

        <script src="{{{ asset('js/jquery-2.2.4.js') }}}"></script>
        <script src="{{{ asset('js/foundation.core.js') }}} "></script>
        <!-- Foundation Reveal -->
        <script src="{{{ asset('js/foundation.util.keyboard.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.box.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.triggers.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.mediaQuery.js') }}} "></script>
        <script src="{{{ asset('js/foundation.util.motion.js') }}} "></script>
        <script src="{{{ asset('js/foundation.reveal.js') }}} "></script>
        <script src="{{{ asset('js/foundation.offcanvas.js') }}}"></script>
        <script src="{{{ asset('js/intro.js') }}}"></script>
        <script src="{{{ asset('js/typed.js')}}}"></script>


        <!-- Needed for Parallax -->
        <script src="{{{ asset('js/parallax.js') }}}"></script>
        <script src="{{{ asset('js/main.js') }}}"></script>


        <script type="text/javascript">

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

        </script>
    </head>
    <body>


        <!--<div class="off-canvas-wrapper">
            <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>-->
          		<!--<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
          			<nav d="site-navigation" class="main-navigation" role="navigation" style="padding:50px 10px; margin-bottom:20px;">
                        <button class="close-button" aria-label="Close menu" type="button" data-close>
                             <span aria-hidden="true">&times;</span>
                        </button>

                        <ul class="vertical menu">
                            <li>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                 {{ csrf_field() }}
                                 <a href="#" class="logout">Logout</a>
                                </form>
                            </li>
                            <li>
                                <a href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <a data-open="completed-status" aria-controls="completed-status" aria-haspopup="true">Create New Campaign</a>
                            </li>
                        </ul>
                     </nav>
          		</div> --><!-- end .off-canvas -->

                <div class="off-canvas-content" data-off-canvas-content>
                  	<section id="fixedWrapper">
              			<div id="header-bar">
            					<header class="header" role="banner">
            						<div class="title-bar">
            							<div class="row">
            								<div class="text-left small-5 columns">
            									<!--<a class="left fa fa-arrow-circle-right triple" data-toggle="offCanvasLeft"></a>-->
            								</div>
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
                                                            <a href="{{ url('/register') }}" class="fa triple fa-user-circle-o"></a>
                                                            @else
                                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                                                {{ csrf_field() }}
                                                                <a href="#" class="logout triple fa fa-sign-out"></a>
                                                            </form>
                                                            <a class="fa fa-tachometer triple" data-step="1" data-intro="Welcome Soldier, good to have you aboard! We're about to take you on a training programme so you know how to use this super weapon that we've created." href="{{ url('/dashboard') }}"></a>
                                                            <a class="fa fa-plus-circle triple" data-open="completed-status" aria-controls="completed-status" aria-haspopup="true"></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
            							</div>
            						</div>
            					</header>
                            </div>
                        @yield('content')
                      </section>
                  </div> <!-- end .off-canvas-content -->
            <!--  </div> end .off-canvas-wrapper-inner -->
         <!-- </div>  end .off-canvas-wrapper -->


    </body>
</html>
