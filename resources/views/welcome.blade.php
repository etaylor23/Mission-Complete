@extends('layouts.wrapper')
@section('content')

<div class="main-content">

    <div class="cover">
      <div class="hi"></div>
    </div>
  <div class="tv">
        <div class="screen mute" id="tv"></div>
  </div>

  <div class="homepage-content">
      <div name="our-mission" class="our-mission">
          <div class="row">
              <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                  <h2>Our Mission</h2>
              </div>
              <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                  <p>
                      What have you acheived today? This week? Last Month? This year? <br/>
                      Cant quite put your finger on it? <br />
                      You aren't the only one!
                  </p>

              </div>
              <div class="column small-12 medium-8 large-8 text-center large-offset-2 global-spacing bottom">
                  <hr>
              </div>
              <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                  <p>
                      In the busy lives that we live we often forget to take care of our own self progression.<br>
                      And how do we quantify when we do something great? We often don't.<br>
                      Mission Complete is here to help. Let us set you on a path for a better you<br>
                      <strong>Mission Complete:</strong>
                      <ul>
                          <li>Gives you structure in your self progression</li>
                          <li>Empowers you to complete and maintain new skills and activities</li>
                          <li><strong>Reminds you how far you've come</strong></li>
                      </ul>
                  </p>
              </div>

          </div>
      </div>
      <div class="parallax-window" data-parallax="scroll" data-image-src="{{{ asset('images/old-planes.jpg') }}}"></div>
      <div name="your-mission" class="your-mission">
          <div class="row">
              <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing top bottom">
                  <h2>Your Mission</h2>
              </div>
              <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                  <p>
                      <strong>Make every day count and keep your self on track.</strong><br />
                      <ol>
                          <li>Create a goal - it can be physical, mental, academic, work or a life goal.</li>
                          <li>Set a time to do it in, and break it up into steps to complete. </li>
                          <li>Create and complete your campaigns and validate your daily actions to ensure your future you is better.</li>
                      </ol>
                      <strong>Or... let Mission Complete do it for you</strong>
                  </p>
              </div>
          </div>
      </div>
    </div>

</div>


@endsection
