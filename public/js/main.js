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

        self.addActiveClass = function addActiveClass(el, container, id, afterAddActiveDone, afterRemoveActiveDone) {
            var scrollTo = new ScrollTo(),
                elPosition = scrollTo.getDistanceFromTop(el, $('.title-bar').outerHeight() + $('.secondary-nav').outerHeight());

            $(window).on('scroll', function() {
              var scrollTop = $(window).scrollTop();
              if(scrollTop > elPosition.top && scrollTop < elPosition.bottom) {
                  if(!container.find('#'+id).hasClass('active')) {
                      container.find('#'+id).addClass('active');
                      if(typeof afterAddActiveDone === 'function') {
                          afterAddActiveDone(el);
                      }
                    //   console.log('Fires once')
                  }

              } else {
                  if(container.find('#'+id).hasClass('active')) {
                      container.find('#'+id).removeClass('active');
                      if(typeof afterRemoveActiveDone === 'function') {
                          afterRemoveActiveDone(el, elPosition);
                      }
                  }

              }
            })
        }

        return {
            generateNav : generateNav
        }
    }

    function ScrollTo() {
        var self = this;

        function init(el) {
            el.on('click', function(event) {
                self.scrollToAnchor($(this).attr('id'));
            })
        }

        self.getDistanceFromTop = function getDistanceFromTop(element, furtherOffset) {
            var top = element.offset().top - furtherOffset,
                bottom = top + element.outerHeight();

            return { 'top' : top, 'bottom' : bottom }
        }

        self.getMatchingSection = function getMatchingSection(id) {
            var section = $("[name='"+ id +"']"),
            distFromTop = self.getDistanceFromTop(section, $('.title-bar').outerHeight());
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

    function SVGPie() {
        var init = function init() {
            $.ajax({
                url: '/api' + window.location.pathname
            }).done(function(data) {
                var type = data.mission || data.campaign,
                    path = "",
                    campaignPercent = $('#campaignPercent'),
                    snap = Snap("#pieSVG"),
                    arc = snap.path(path),
                    outOfOneHundred = type.percent_complete,
                    panes = new Panes();
                panes.run(outOfOneHundred/100.1, campaignPercent[0], snap, arc, "#67DB88", 24);
            })
        }
        return {
            init : init
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

    function Isotopes() {
        var self = this;

        function init() {
            if($('.portfolioContainer').length > 0) {
                var $container = $('.portfolioContainer');
                $container.isotope({
                    filter: '*',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    },
                    masonry: {
                      gutter: 10
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
            }

            var missionContainer = $('.missions');
            if(missionContainer.length > 0) {
                missionContainer.isotope({
                    filter: '*',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    },
                    masonry: {
                      gutter: 10,
                      columnWidth: '.grid-sizer'
                    }
                });

                $('.campaigns .campaign-filter').click(function() {
                  var selector = $(this).attr('data-filter');
                  missionContainer.isotope({
                      filter: selector,
                      animationOptions: {
                          duration: 750,
                          easing: 'linear',
                          queue: false
                      }
                   });
                   return false;
                })
            }
        }

        return {
            init : init
        }
    }

    function D3Tree() {
        var self = this;

        function init() {
            var margin = {top: 20, right: 120, bottom: 20, left: 250},
                width = 960 - margin.right - margin.left,
                height = 500 - margin.top - margin.bottom;

            var i = 0,
                duration = 750,
                root;

            var tree = d3.layout.tree()
                .size([height, width]);

            var diagonal = d3.svg.diagonal()
                .projection(function(d) { return [d.y, d.x]; });

            var svg = d3.select(".tree").append("svg")
                .attr("width", width + margin.right + margin.left)
                .attr("height", height + margin.top + margin.bottom)
              .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            d3.json('/api' + window.location.pathname, function(error, flare) {

              if (error) throw error;

              root = flare.campaign;
              root.x0 = height / 2;
              root.y0 = 0;

              function collapse(d) {
                if (d.children) {
                  d._children = d.children;
                  d._children.forEach(collapse);
                  d.children = null;
                }
              }

              if(root.children.length > 1) {
                  root.children.forEach(collapse);
                  update(root);
              } else {
                  $('.tree-container').remove();
              }
            });

            d3.select(self.frameElement).style("height", "800px");

            function update(source) {

              // Compute the new tree layout.
              var nodes = tree.nodes(root).reverse(),
                  links = tree.links(nodes);

              // Normalize for fixed-depth.
              nodes.forEach(function(d) { d.y = d.depth * 180; });

              // Update the nodes…
              var node = svg.selectAll("g.node")
                  .data(nodes, function(d) { return d.id || (d.id = ++i); });

              // Enter any new nodes at the parent's previous position.
              var nodeEnter = node.enter().append("g")
                  .attr("class", "node")
                  .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
                  .on("click", click);

              nodeEnter.append("circle")
                  .attr("r", 1e-6)
                  .style("fill", function(d) { return d._children ? "#5b7632" : "#fff"; });

              nodeEnter.append("text")
                  .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
                  .attr("dy", "1em")
                  .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
                  .text(function(d) { return d.name; })
                  .style("fill-opacity", 1e-6);

              // Transition nodes to their new position.
              var nodeUpdate = node.transition()
                  .duration(duration)
                  .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

              nodeUpdate.select("circle")
                  .attr("r", 10)
                  .style("fill", function(d) { return d._children ? "#002F6F" : "#fff"; });

              nodeUpdate.select("text")
                  .style("fill-opacity", 1);

              // Transition exiting nodes to the parent's new position.
              var nodeExit = node.exit().transition()
                  .duration(duration)
                  .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
                  .remove();

              nodeExit.select("circle")
                  .attr("r", 1e-6);

              nodeExit.select("text")
                  .style("fill-opacity", 1e-6);

              // Update the links…
              var link = svg.selectAll("path.link")
                  .data(links, function(d) { return d.target.id; });

              // Enter any new links at the parent's previous position.
              link.enter().insert("path", "g")
                  .attr("class", "link")
                  .attr("d", function(d) {
                    var o = {x: source.x0, y: source.y0};
                    return diagonal({source: o, target: o});
                  });

              // Transition links to their new position.
              link.transition()
                  .duration(duration)
                  .attr("d", diagonal);

              // Transition exiting nodes to the parent's new position.
              link.exit().transition()
                  .duration(duration)
                  .attr("d", function(d) {
                    var o = {x: source.x, y: source.y};
                    return diagonal({source: o, target: o});
                  })
                  .remove();

              // Stash the old positions for transition.
              nodes.forEach(function(d) {
                d.x0 = d.x;
                d.y0 = d.y;
              });
            }

            // Toggle children on click.
            function click(d) {
              if (d.children) {
                d._children = d.children;
                d.children = null;
              } else {
                d.children = d._children;
                d._children = null;
              }
              update(d);
            }
        }

        return {
            init : init
        }

    }

    function Panes() {
        var self = this;

        var canvasSize = 250,
            centre = canvasSize/2,
            radius = canvasSize*0.8/2,
            path = "";
            startY = centre-radius;

        function run(percent, el, snap, arc, strokeColour, strokeWidth) {
            var endpoint = percent*360;
            Snap.animate(0, endpoint,   function (val) {
                arc.remove();

                var d = val,
                    dr = d-90;
                    radians = Math.PI*(dr)/180,
                    endx = centre + radius*Math.cos(radians),
                    endy = centre + radius * Math.sin(radians),
                    largeArc = d>180 ? 1 : 0;
                    var path = "M"+centre+","+startY+" A"+radius+","+radius+" 0 "+largeArc+",1 "+endx+","+endy;

                arc = snap.path(path);
                arc.attr({
                  stroke: strokeColour || '#4D9E69',
                  fill: 'none',
                  strokeWidth: strokeWidth || 12
                });
                el.innerHTML =    Math.round(val/360*100) +'%';

            }, 2000);
        }

        function drawArcs() {

          $('.completeness svg').each(function() {
            var snapId = "#"+$(this).attr('id');
            var snap = Snap(snapId),
                arc = snap.path(path);

            var outOfOneHundred = $(this).parent().siblings('.end').html().trim();
            run(outOfOneHundred/100.1, $(this).siblings('#percent')[0], snap, arc);

          });

        }

        function init() {
            $('.inner-column').hover(function() {
                function slideObjectives() {
                    if($(this).find('.listing-wrapper').find('li').length > 0) {
                        $(this).find('.listing-wrapper').slideToggle("slow", function() {
                          var missionContainer = $('.missions');
                          missionContainer.isotope( 'layout' );
                        });
                    }
                }
                setTimeout(slideObjectives.bind($(this)), 700);
            })

            $('.missions .inner-column').each(function() {
              if(typeof $(this).attr('parent') !== 'undefined') {
                $(this).hover(function() {
                    // var $self = $(this);
                    function addActiveChild() {

                        var $this = this,
                             parentSlug = $this.attr('parent'),
                             campaignInnerColumn = $('.campaigns').find('.inner-column[top="' + parentSlug + '"]'),
                             aCampaign = campaignInnerColumn.toggleClass('active-child');

                    }

                    setTimeout(addActiveChild.bind($(this)), 700);
                })
              }
            });

            drawArcs();
        }

        return {
            init : init,
            drawArcs : drawArcs,
            run : run
        }
    }

    function Select2() {
        var self = this;

        function init() {
            $('select').select2({
              ajax: {
                url: "/campaign/list",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    q: params.term, // search term
                    page: params.page
                  };
                },
                processResults: function (data, params) {
                  // parse the results into the format expected by Select2
                  // since we are using custom formatting functions we do not need to
                  // alter the remote JSON data, except to indicate that infinite
                  // scrolling can be used
                  // params.page = params.page || 1;

                  return {
                    results: data,
                  };
                },
                cache: true
              },
              escapeMarkup: function (markup) { return markup; },
              minimumInputLength: 2,
              templateResult: function(item) {
                if (item.text) {
                    return '<div style="color:blue">' + item.text + '</div>';
                } else {
                    return '<div>' + item.name + '</div>';
                }
              },
              templateSelection: function(selected) {
                return selected.name || selected.text;
              },
              tags: true
            });
        }

        return {
            init : init
        }
    }

    function Chat() {
        var self = this;

        var $messages = $('.messages-content'),
            d, h, m,
            i = 0;

        function updateScrollbar() {
          $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
            scrollInertia: 10,
            timeout: 0
          });
        }

        function setDate(){
            d = new Date()
            m = d.getMinutes();
            return $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
        }

        function insertMessage(_this, message) {
          var chatContainer = _this.parents('.chat').find('.messages-content')
          var date = setDate();
          var message = $('<div class="message message-personal">' + message + '</div>')
          var fullMessage = date.appendTo(message);
          chatContainer.append(message).addClass('new');
          message.append(date);
          $('.message-input').val(null);
          updateScrollbar();
        }

        function insertAjaxMessage() {
            var _this = this;
            _this.parents('form').submit(function(e) {
              var url = $(this).attr('action');

              $.ajax({
                type: "POST",
                url: url,
                data: _this.parents('form').serialize(),
                context: _this,
                success: function(data) {
                  insertMessage(this, data.message.message);
                }
              })
              e.preventDefault();
            })

        }

        function init() {
            if($('.posts').length > 0) {


                $('.message-submit').each(function() {
                  insertAjaxMessage.apply($(this));
                });

                $('.message-input').on('keydown', function(e) {
                  if (e.which == 13) {
                    $(this).parents('form').submit();
                    return false;
                  }
                })

            }
        }
        return {
            init : init,
            insertAjaxMessage : insertAjaxMessage
        }
    }

    this.init = function() {
        var objective = new Objective();
        objective.slideMaintenance();

        var authentication = new Authentication();
        authentication.logout('.logout');

        $('.hi').typed({
            strings: ["Mission Complete... ✓", "The First 'To Be' List"],
            typeSpeed: 5
        });

        var navigation = new Navigation();
        /**
        * Pass:
        * - Sections to generate navigation from
        * - Navigation container to append to
        * - A callback for once the active class has been applied
        * - A callback for once the active class has been removed
        * - Hint: Pass one level of navigation down to child levels by nesting generateNav calls.
        *       - The callback emits an el for context
        *       - E.g. el in data-level primary will be our-mission or your-mission
        *       - This can be used to build child navigation
        */
        navigation.generateNav($('[data-level="primary"]'), $('.main-nav'), function(el) {
            navigation.generateNav(el.find('[data-level="secondary"]'), $('.secondary-nav'));
            $('.secondary-nav').removeClass('hidden').css({'margin-top':'0'});

        }, function() {
            $('.secondary-nav').addClass('hidden').css({'margin-top':'-55px'});
        })

        var transparenyModifier = new TransparencyModifier();
        transparenyModifier.init();

        var svgPie = new SVGPie();
        svgPie.init();

        var isotopes = new Isotopes();
        isotopes.init();

        var d3Tree = new D3Tree();
        d3Tree.init();

        var panes = new Panes();
        panes.init();

        var select2Config = new Select2();
        select2Config.init();

        var chat = new Chat();
        chat.init();

        if (typeof currentUserSkills !== 'undefined') {
          currentUserSkills.forEach(function(skill) {
            Echo.channel('chat-room.' + skill + '.' + window.userid)
            .listen('ObjectiveComplete', function(e) {
              var test = $('<div class="objects tests columns large-3 ' + e.message.skill_name + '"><div class="post-inner"><h3>' + e.user.name + '</h3>' + e.message.post_content + '</div></div>');
              var chatContainer = $('<div data-thread-id="" data-post-id="" class="chat objects tests columns large-3">' +
                                      '<div class="chat-title">' +
                                          '<h1>'+ e.user.name +'</h1>' +
                                          '<h2>' + e.message.skill_name + '</h2>' +
                                          '<figure class="avatar">' +
                                              '<img src="/images/profiles/'+e.user.image+'" />' +
                                          '</figure>' +
                                      '</div>' +
                                      '<div class="chat-title">' +
                                          '<h2>' +
                                              'Talk to them about ' + e.message.skill_name +
                                          '</h2>' +
                                      '</div>' +
                                      '<div class="messages">' +
                                          '<div class="messages-content">' +
                                          '</div>' +
                                      '</div>' +
                                      '<div class="message-box">' +
                                          '<form method="POST" action="/messages" accept-charset="UTF-8">' +
                                              '<input name="_token" type="hidden" value="' + window.csrf +'">' +
                                              '<textarea class="message-input" placeholder="Type message..." name="message" cols="50" rows="10"></textarea>' +
                                              '<input name="thread" type="hidden" value="0">' +
                                              '<input name="post" type="hidden" value="' + e.message.post_id + '">' +
                                              '<input class="button submit message-submit" type="submit" value="Send!">' +
                                            '</form>' +
                                      '</div>' +
                                    '</div>');

              $('.portfolioContainer')
              .append(chatContainer)
              .isotope('appended', chatContainer);

              var chat = new Chat();
              chat.insertAjaxMessage.apply(chatContainer.find('.message-submit'));
              $('.message-input').off();
              $('.message-input').on('keydown', function(e) {
                if (e.which == 13) {
                  $(this).parents('form').submit();
                  return false;
                }
              })
            });
          });
        };

        if($(".trigger").length > 0) {
            $(".trigger").toggleClass("drawn");
        }

        $('.parallax-window').hover(function() {
        	$(this).children('.overlay').fadeToggle(400)
        });

    }
}



jQuery(document).ready(function($) {
    $(document).foundation();
    var app = new App();
    app.init();
})
