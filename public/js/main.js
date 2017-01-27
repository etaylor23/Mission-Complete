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
                    })
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

    function TransparencyModifier() {
        this.init = function(element, transparencyClass, distFromTop) {
            var defaults = {
                element             : '.title-bar',
                transparencyClass   : 'not-top',
                distFromTop         : '40'
            }

            Object.assign(defaults, {
                element: element || defaults.element,
                transparencyClass: transparencyClass || defaults.transparencyClass,
                distFromTop: distFromTop || defaults.distFromTop
            });

            $(window).scroll(function(event) {
              if(Math.round($(this).scrollTop()) > defaults.distFromTop) {
                $(defaults.element).addClass(defaults.transparencyClass);
              } else {
                $(defaults.element).removeClass(defaults.transparencyClass);
              }
            });
        }
    }

    function Navigation() {
        var self = this;

        function generateNav(dataLevel, navLevelContainer, afterAddActiveDone, afterRemoveActiveDone) {
            //nav container selector
            //data-levell selector
            //cb?

            var navContainer = navLevelContainer,
                navlinks = "";

            dataLevel.each(function() {
                var el = $(this),
                    className = el.attr('class') || el.find('h3').text(),
                    id = className.toLowerCase().replace(/ /g, '-'),
                    linkText = className.replace('-', ' ');

                navlinks += '<a id="' + id + '" href="#' + id + '" class="global-spacing left">' + linkText + '</a>';

                self.addActiveClass(el, navContainer, id, afterAddActiveDone, afterRemoveActiveDone);
            });

            navContainer.empty();
            navContainer.append(navlinks);

                    var scrollTo = new ScrollTo();
                    scrollTo.init(navLevelContainer.find('a'));
        }


        function primary() {

            var mainNavContainer = $('.main-nav'),
                mainNavlinks = "";

            $('[data-level="primary"]').each(function() {
                var el = $(this),
                  className = el.attr('class');

                mainNavlinks += '<a id="' + className + '" href="#' + className + '" class="global-spacing left">' + className.replace('-', ' ') + '</a>';

                self.addActiveClass(el, mainNavContainer, className, function(el, elPosition) {
                    var secondaryNav = $('.secondary-nav'),
                        secondaryNavLinks = "";

                    el.find('[data-level="secondary"]').each(function() {
                        var navLink = $(this).find('h3').text()
                        secondaryNavLinks += '<a id=' + navLink.replace(/ /g, '-').toLowerCase() + '>' + navLink + '</a>';
                        self.addActiveClass($(this), secondaryNav, navLink.replace(/ /g, '-').toLowerCase())

                    });
                    secondaryNav.empty();
                    secondaryNav.append(secondaryNavLinks);
                    secondaryNav.removeClass('hidden');
                    secondaryNav.css({'margin-top': 0});
                    var scrollTo = new ScrollTo();
                    scrollTo.init(secondaryNav.find('a'));

                });


            });

            mainNavContainer.empty();
            mainNavContainer.append(mainNavlinks);
        }

        self.addActiveClass = function addActiveClass(el, container, id, afterAddActiveDone, afterRemoveActiveDone) {
            var scrollTo = new ScrollTo(),
                elPosition = scrollTo.getDistanceFromTop(el);

            $(window).on('scroll', function() {
              var scrollTop = $(window).scrollTop();
              if(scrollTop > elPosition.top && scrollTop < elPosition.bottom) {
                  if(!container.find('#'+id).hasClass('active')) {
                      container.find('#'+id).addClass('active');
                      if(typeof afterAddActiveDone === 'function') {
                          afterAddActiveDone(el);
                      }
                    //   if(container.hasClass('hidden')) {
                    //       container.removeClass('hidden');
                    //       container.css('margin-top', '0');
                    //   }
                      console.log('Fires once')
                  }

              } else {
                  if(container.find('#'+id).hasClass('active')) {
                      container.find('#'+id).removeClass('active');
                      if(typeof afterRemoveActiveDone === 'function') {
                          afterRemoveActiveDone(el, elPosition);
                      }
                    //   if(!container.hasClass('hidden')) {
                    //       container.addClass('hidden');
                    //       container.css('margin-top', '-55px');
                    //   }
                  }

              }
            })
        }


        return {
            primary : primary,
            generateNav : generateNav
        }
    }

    function ScrollTo() {
        var self = this;

        function init(el) {
            //for every anchor with data-nav-level - get the id
            //call getMatchingSection with each id which will return the top and bottom for the matching id
            //when the user scrolls between the top and bottom add an active class to that anchor
            //find that anchors sub navigation - data-nav-level secondary with identical id and populate it with an object of anchors based on all .secondary that have identical id
            //call event listeners on secondary nav links
            el.on('click', function(event) {
                self.scrollToAnchor($(this).attr('id'));
            })
        }

        self.getDistanceFromTop = function getDistanceFromTop(element) {
            var top = element.offset().top - 110,
                bottom = top + element.outerHeight();

            return { 'top' : top, 'bottom' : bottom }
            //110 is the height of the fixed nav
        }

        self.getMatchingSection = function getMatchingSection(id) {
            var section = $("[name='"+ id +"']"),
            distFromTop = self.getDistanceFromTop(section);
            return distFromTop;
        }

        self.scrollToAnchor = function scrollToAnchor(aid){
            var distFromTop = self.getMatchingSection(aid);
            $('html,body').animate({scrollTop: distFromTop.top},'slow');
        }

        return {
            init : init,
            getDistanceFromTop : self.getDistanceFromTop
        }
    }

    function Authentication() {
        var self = this;

        function logout(logoutButton) {
            if($(logoutButton).length > 0) {
                $(logoutButton).click(function(event) {
                    event.preventDefault();
                    $(this).parent('form').submit();
                });
            }
        }

        return {
            logout : logout
        }
    }

    this.init = function() {
        var objective = new Objective();
        objective.slideMaintenance();

        var tour = new Tour();
        tour.init();

        var authentication = new Authentication();
        authentication.logout('.logout');

        $('.hi').typed({
            strings: ["Mission Complete... ✓", "The First 'To Be' List"],
            typeSpeed: 5
        });

        var navigation = new Navigation();


        navigation.generateNav($('[data-level="primary"]'), $('.main-nav'), function(el) {
            navigation.generateNav(el.find('[data-level="secondary"]'), $('.secondary-nav'));
            $('.secondary-nav').removeClass('hidden').css({'margin-top':'0'});

        }, function() {
            $('.secondary-nav').addClass('hidden').css({'margin-top':'-55px'});
        })


        var transparenyModifier = new TransparencyModifier();
        transparenyModifier.init();

    }
}



jQuery(document).ready(function($) {
    $(document).foundation();
    var app = new App();
    app.init();
})
