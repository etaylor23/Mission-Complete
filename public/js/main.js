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

    function D3Pie() {
        var self = this;

        self.init = function init() {
            $.ajax({
                url: '/api' + window.location.pathname
            }).done(function(data) {
                var totalPie = 100,
                    type = data.mission || data.campaign,
                    incomplete = totalPie - type.percent_complete;

                var pie = new d3pie("pie", {
                    header: {
                        //title: {
                        //  text: $('h1').text()
                        //},
                        location: "pie-center"
                    },
                    size: {
                        pieInnerRadius: "50%"
                    },
                    data: {
                        sortOrder: "label-asc",
                        content: [
                          { label: "Complete", value: type.percent_complete},
                          { label: "Incomplete", value: incomplete},
                        ]
                    }
                });
            })
        }

        return {
            init : self.init
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

        var d3Pie = new D3Pie();
        d3Pie.init();







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

          root.children.forEach(collapse);
          update(root);
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
              .style("fill", function(d) { return d._children ? "#5b7632" : "#fff"; });

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
}



jQuery(document).ready(function($) {
    $(document).foundation();
    var app = new App();
    app.init();
})
