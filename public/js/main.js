function App() {
    function Objective() {
        this.slideMaintenance = function() {
            if($('.alert').length > 0) {
                $('.alert').each(function() {
                    $(this).on('click', '.expand', function() {
                        $(this).siblings('.plan').slideToggle('slow', function() {
                            $(this).toggleClass('hidden');
                        });
                    })
                })
            }
        }
    }

    function Tour() {
        this.init = function() {
            if(localStorage.getItem('tour-complete') !== null) {
                localStorage.removeItem('tour');
                $('#header-bar').find('[data-step]').attr('data-intro', 'Good job, now that your training is complete I dare say you have earned a promotion.')
            }
            if(localStorage.getItem('tour') !== null) {
                $('#header-bar').find('[data-step]').each(function() {
                    $(this).removeAttr('data-step').removeAttr('data-intro');
                })
            }

            if(localStorage.getItem('tour-complete') === null) {
                var intro = introJs()
                intro.setOption('doneLabel', 'Next page')
                intro.start();

                if(window.location.pathname.indexOf('objective') > 0) {
                    intro.oncomplete(function() {
                        localStorage.setItem("tour-complete", "true");
                        window.location.href = '/dashboard';
                    })//.onchange(function(targetElement) {
                    //     if($(targetElement).attr('data-step') == '3') {
                    //         console.log(targetElement);
                    //         $('button.button').click();
                    //     }
                    // });
                } else if(window.location.pathname.indexOf('mission') > 0) {
                    intro.oncomplete(function() {
                        window.location.href = '/campaign/your-very-first-campaign/mission/your-very-first-mission/objective/your-very-first-objective';
                    })
                } else if(window.location.pathname.indexOf('campaign') > 0) {
                    intro.oncomplete(function() {
                        window.location.href = '/campaign/your-very-first-campaign/mission/your-very-first-mission';
                    });
                } else {
                    intro.oncomplete(function() {
                        localStorage.setItem("tour", "true");
                        window.location.href = '/campaign/your-very-first-campaign';
                    });
                }
            }
        }
    }

    this.init = function() {
        var objective = new Objective();
        objective.slideMaintenance();
        var tour = new Tour();
        tour.init();
        console.log('Init');

        $('.logout').click(function(event) {
            event.preventDefault();
            $(this).parent('form').submit()
        });

        $('.hi').typed({
            strings: ["Mission Complete... ✓", "The First 'To Be' List"],
            typeSpeed: 5
        });

        function scrollToAnchor(aid){
            var aTag = $("[name='"+ aid +"']");
            //-110 because of fixed header
            $('html,body').animate({scrollTop: (aTag.offset().top - 110)},'slow');
        }


        $('.nav a').on('click', function(event) {
          console.log($(this).attr('id'));
          scrollToAnchor($(this).attr('id'));
        })

        $(window).scroll(function(event, top) {
          if(Math.round($(this).scrollTop()) > 40) {
            $('.title-bar').addClass('not-top');
          } else {
        	$('.title-bar').removeClass('not-top');
          }
        });

    }
}



jQuery(document).ready(function($) {
    $(document).foundation();
    var app = new App();
    app.init();
})
