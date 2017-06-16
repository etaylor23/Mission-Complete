@extends('layouts.wrapper')
@section('content')

<div class="main-content">

  <!-- <div class="tv">
        <div class="screen mute" id="tv"></div>
  </div> -->
  <div class="parallax-window extra large" data-parallax="scroll" data-ios-fix="true" data-image-src="http://localhost:8888/images/tank-1.jpg">
    <div class="cover">
      <div class="hi"></div>
      <div class="play-container">
        <a href="#" class="fa fa-play-circle-o" data-open="introduction-video"></a>
      </div>


      <div class="reveal" id="introduction-video" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/B0VXudy-2UI" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>
  </div>


  <div class="homepage-content">
      <div name="our-mission" class="our-mission" data-level="primary">
          <div class="parallax-window" data-parallax="scroll" data-ios-fix="true">
              <div class="icon-container primary">
                  <img src="{{{ asset('images/mission-complete.png') }}}" />
              </div>


              <div class="overlay hidden">
                  <div class="overlay-inner">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h2>Mission Complete</h2>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <div>
                                  <div>Builds confidence by enabling effective self improvement</div>
                                  <div>Helps you recognise that self improvement</div>
                                  <div>Kickstarts the motviation loop to be a better person</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


      <div name="effort-output-vs-feedback" data-level="secondary">
          <div class="parallax-window" data-parallax="scroll" data-ios-fix="true" data-image-src="{{{ asset('images/old-planes.jpg') }}}">
              <div class="icon-container">
                  <div class="fa fa-superpowers"></div>
              </div>

              <div class="overlay hidden">
                  <div class="overlay-inner">
                       <div class="row">
                           <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                               <h3>Effort Output vs Feedback</h3>
                           </div>
                           <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                               <p>
                                   <strong>Whats it worth?</strong>
                               </p>
                               <p>Hours of work, and for what? We'll tell you exactly what</p>
                               <p>We provide you your very own structured self improvement plan that grows as you do</p>
                           </div>
                       </div>
                    </div>
                </div>
          </div>
    </div>


    <div name="self-progression" data-level="secondary">
        <div class="parallax-window">
            <div class="icon-container">
                <div class="fa fa-thumbs-o-up"></div>
            </div>

            <div class="overlay hidden">
                <div class="overlay-inner">
                    <div class="row">
                        <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Self Progression</h3>
                        </div>
                        <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                            <p>We'll make sure you stay on track with just the right amount of work</p>
                            <p>So you can take off on your journey to a <strong>stronger, faster, smarter, wealthier</strong> and <strong>happier</strong> you</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div name="completion-and-maintenance" data-level="secondary">
        <div class="parallax-window" data-parallax="scroll" data-ios-fix="true"  data-image-src="{{{ asset('images/war-2.jpg') }}}">
            <div class="icon-container">
                <div class="fa fa-check"></div>
            </div>
            <div class="overlay hidden">
                <div class="overlay-inner">
                    <div class="row">
                      <div class="column small-12 medium-5 large-5 text-center large-offset-3 global-spacing bottom">
                          <h3>Completion and Maintenance</h3>
                      </div>
                      <div class="column small-12 medium-7 large-7 text-center large-offset-2">
                          <p>Once you've hit your goal you have to keep it fresh and up to date<br />
                          <p>We'll take care of letting you know when and how to do that</p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div name="acheive-and-quantify" data-level="secondary">
      <div class="parallax-window">
          <div class="icon-container">
              <div class="fa fa-cogs"></div>
          </div>

          <div class="overlay hidden">
              <div class="overlay-inner">
                    <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Acheive and Quantify</h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                            <p>All that effort deserves a reward for completing their missions</p>
                            <p>Let us show you how far you've come</p>
                          </div>
                      </div>
                </div>
            </div>
        </div>
    </div>


          <!--</div>-->
  </div>
      <div class="parallax-window" data-parallax="scroll" data-ios-fix="true" data-image-src="{{{ asset('images/war-1.jpg') }}}"></div>
      <!--<div name="your-mission" class="your-mission" data-level="primary">
          <div class="row">
              <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing top bottom">
                  <h2>Your Mission</h2>
              </div>

              <div class="columns small-12 medium-12 large-12">
                  <div name="test" data-level="secondary">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Test test</h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <p>Have your very own structured self improvement plan that grows as you do</p>
                          </div>
                        </div>
                  </div>
              </div>

              <div class="columns small-12 medium-12 large-12">
                  <div name="test-1" data-level="secondary">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Test 1 </h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <p>Have your very own structured self improvement plan that grows as you do</p>
                          </div>
                        </div>
                  </div>
              </div>

              <div class="columns small-12 medium-12 large-12">
                  <div name="test-2" data-level="secondary">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Test 2</h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <p>Have your very own structured self improvement plan that grows as you do</p>
                          </div>
                        </div>
                  </div>
              </div>

              <div class="columns small-12 medium-12 large-12">
                  <div name="test-3" data-level="secondary">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Test 3</h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <p>Have your very own structured self improvement plan that grows as you do</p>
                          </div>
                        </div>
                  </div>
              </div>

              <div class="columns small-12 medium-12 large-12">
                  <div name="test-4" data-level="secondary">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Test 4</h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <p>Have your very own structured self improvement plan that grows as you do</p>
                          </div>
                      </div>
                  </div>
              </div>

            <div class="columns small-12 medium-12 large-12">
                <div name="test-4" data-level="secondary">
                    <div class="row">
                        <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                            <h3>Test 4</h3>
                        </div>
                        <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                            <p>Have your very own structured self improvement plan that grows as you do</p>
                        </div>
                    </div>
                </div>
            </div>

              <div class="columns small-12 medium-12 large-12">
                  <div name="test-4" data-level="secondary">
                      <div class="row">
                          <div class="column small-12 medium-4 large-4 text-center large-offset-4 global-spacing bottom">
                              <h3>Test 4</h3>
                          </div>
                          <div class="column small-12 medium-8 large-8 text-center large-offset-2">
                              <p>Have your very own structured self improvement plan that grows as you do</p>
                          </div>
                      </div>
                  </div>
              </div>

          </div>
      </div>-->


      <footer>
          <div class="row">
              <div class="small-12 medium-6 large-6 column">
                  <strong>Mission Complete ©</strong>
              </div>
              <div class="small-12 medium-6 large-6 column">
                  <a href="mailto:ellis.taylor499@gmail.com">Contact Us</a>
              </div>
          </div>
      </footer>
    </div>

</div>


@endsection
