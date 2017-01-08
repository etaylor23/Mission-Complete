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


        <!-- Needed for Parallax -->
        <script src="{{{ asset('js/parallax.js') }}}"></script>
        <script src="{{{ asset('js/main.js') }}}"></script>
    </head>
    <body>

        <!--<div class="parallax-window" data-parallax="scroll" data-image-src="{{{ asset('images/NtU7cMK.jpg') }}}"></div>-->

        <div class="off-canvas-wrapper">
            <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
          		<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
          			<nav d="site-navigation" class="main-navigation" role="navigation" style="padding:50px 10px; margin-bottom:20px;">
                        <!-- Close button -->
                        <button class="close-button" aria-label="Close menu" type="button" data-close>
                             <span aria-hidden="true">&times;</span>
                        </button>

                         <!-- Menu -->
                        <ul class="vertical menu">
                            <li><a href="#">Foundation</a></li>
                            <li><a href="#">Dot</a></li>
                            <li><a href="#">ZURB</a></li>
                            <li><a href="#">Com</a></li>
                            <li><a href="#">Slash</a></li>
                            <li><a href="#">Sites</a></li>
                        </ul>
                     </nav>
          		</div> <!-- end .off-canvas -->

                <div class="off-canvas-content" data-off-canvas-content>
                  	<section id="fixedWrapper">
              			<div id="header-bar">
            					<header class="header" role="banner">
            						<div class="title-bar">
            							<div class="row">
            								<div class="text-left small-5 columns">
            									<button class="left menu-icon" type="button" data-toggle="offCanvasLeft"></button>
            								</div>
            								<div class="home-logo text-center small-2 columns">
            									<a href="/dashboard">
                                                    <img src="{{{ asset('images/mission-complete.png') }}}" />
                                                </a>
            								</div>
            								<div class="text-right small-5 columns">
                                                @if (Route::has('login'))
                                                    <div class="top-right nav-links-row row">
                                                        <div class="nav-links">
                                                            @if(!Auth::check())
                                                            <a href="{{ url('/login') }}">Login</a>
                                                            <a href="{{ url('/register') }}">Register</a>
                                                            @endif
                                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                                                {{ csrf_field() }}
                                                                <a href="#" class="logout triple fa fa-sign-out"></a>
                                                            </form>
                                                            <a class="fa fa-tachometer triple" data-step="1" data-intro="Welcome Soldier, good to have you aboard! We're about to take you on a training programme so you know how to use this super weapon that we've created." href="{{ url('/dashboard') }}"></a>

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
              </div> <!-- end .off-canvas-wrapper-inner -->
          </div> <!-- end .off-canvas-wrapper -->
    </body>
</html>
