@extends('layouts.wrapper')
@section('content')

@if($campaign)
    <div class="main-content">
        <div class="row">
            <div class="column small-12 medium-6 large-9">
                <h1 data-step="2" data-intro="Okay, this is your first campaign. The idea of a campaign is to create a long term aim, this might last a couple of months or even a couple of years or more.
                                            It has to mean a lot to you, (you'll be focussing on it for a long time) but it doesn't have to be too specific. Good examples are:
                                            <ul>
                                                <li>I want to earn more money</li>
                                                <li>I want to get fitter and stronger</li>
                                            </ul>
                                            See, not too specifc - some may say that its not very measurable, its okay we'll cover the specifics in just a second.">{{ $campaign->name }}</h1>
                <div class="reveal" id="completed-status" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-down">
                    <div class="row">
                          {!! Form::open(['action' => 'MissionsContoller@store', 'class' => 'row']) !!}
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name') !!}
                                </div>
                                <div class="column small-12 medium-12 large-12">
                                    {!! Form::label('description', 'About this mission') !!}
                                    {!! Form::textarea('description', null, ['size' => '30x5']) !!}
                                </div>

                                {!! Form::hidden('done', '0') !!}

                                <div class="column small-12 medium-4 large-4">
                                    {!! Form::submit('Create new mission', ['class' => 'button']) !!}
                                </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="column">
                {!! Breadcrumbs::render('campaign.show', $campaign) !!}
            </div>
        </div>
        <div class="row">
            <div class="columns small-12 medium-3 large-3">
                <div data-step="3" data-intro="Just like you can create a campaign, you can delete one if you feel that its just not you anymore. But before you do, ask yourself what's changed? <br />
                                                Did you take this task on too lightly? Was the aim slightly misplaced?" class="callout">
                    <div class="row">
                        <div class="column small-12 medium-12 large-12">
                        {!! Form::open(['method' => 'DELETE', 'action' => ['CampaignsController@destroy', $campaign->slug]]) !!}
                          {!! Form::submit('Delete this campaign', ['class' => 'button full-width']) !!}
                        {!! Form::close() !!}
                        </div>
                        @if(session('deletedMission'))
                            <div class="column small-12 medium-12 large-12">
                                <strong>{{session('deletedMission')}}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="columns small-12 medium-3 large-3">
                <div data-step="4" data-intro="This pane shows you how complete your campaign is, based on all of its missions and objectives." class="callout">
                    @if(count($relatedMissions) === 0)
                        <strong>You have no missions in this campaign, create one now</strong>
                    @else
                        <div class="percent-complete text-center">
                            <div>{{ $campaign->name }} is:</div>
                            <div><strong>{{$campaign->percent_complete}}%</strong></div>
                            <div>complete</div>
                        </div>
                    @endif
                </div>
            </div>
            @if(!is_null($missionClosestToCompletion))
            <div class="columns small-12 medium-3 large-3 text-center">
                <div data-step="5" data-intro="This area tells you your closest mission to completion, just incase you needed that extra boost to finish it." class="callout">
                    <strong>Mission Closest To Completion:<br />{{$missionClosestToCompletion->name}}</strong>
                </div>
            </div>
            @endif

            <div class="columns small-12 medium-3 large-3 text-center">
                <div data-step="6" data-intro="Lastly, this pane will tell you when you first created the campaign, it'll give you some idea into how much work you've put into it." class="callout">
                    <strong>You started this campaign {{ $timeSinceCreation }}</strong>
                </div>
            </div>
        </div>

        <div data-step="7" data-intro="Here you can see all of your missions for this campaign, lets look at a mission together right now." class="row">
            <div class="column small-12 medium-6 large-6">
                <div class="callout">
                    <h2>Open missions</h2>
                    <ul class="open-missions listing">
                        @foreach ($relatedMissions as $mission)
                            @if($mission->percent_complete  !== 100)
                            <li>
                                <div class="card">
                                    <div class="summary">
                                        <a href="/campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">{{ $mission->name }}</a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="column small-12 medium-6 large-6">
                <div class="callout">
                    <h2>Complete missions</h2>
                    <ul class="open-missions listing">
                        @foreach ($relatedMissions as $mission)
                            @if($mission->percent_complete  === 100)
                            <li>
                                <div class="card">
                                    <div class="summary">
                                        <a href="/campaign/{{$mission->Campaign->slug}}/mission/{{$mission->mission_slug}}">{{ $mission->name }}</a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="column small-12 medium-12 large-21">
                <div class="callout tree">
                </div>
            </div>
        </div>
    @else
        <h1>You cannot access this campaign</h1>
    @endif

    </div>


        <style>

        .node {
          cursor: pointer;
        }

        .node circle {
          fill: #fff;
          stroke: steelblue;
          stroke-width: 1.5px;
        }

        .node text {
          font: 10px sans-serif;
        }

        .link {
          fill: none;
          stroke: #ccc;
          stroke-width: 1.5px;
        }

        </style>


        <script>

        var margin = {top: 20, right: 120, bottom: 20, left: 120},
            width = 960 - margin.right - margin.left,
            height = 400 - margin.top - margin.bottom;

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

        d3.json("/js/flare.json", function(error, flare) {
          if (error) throw error;

          root = flare;
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
              .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

          nodeEnter.append("text")
              .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
              .attr("dy", ".35em")
              .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
              .text(function(d) { return d.name; })
              .style("fill-opacity", 1e-6);

          // Transition nodes to their new position.
          var nodeUpdate = node.transition()
              .duration(duration)
              .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

          nodeUpdate.select("circle")
              .attr("r", 4.5)
              .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

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

        </script>

        <div id="pie"></div>

        <script>
        var pie = new d3pie("pie", {
            header: {
                title: {
                  text: "A Simple Donut Pie"
                },
                location: "pie-center"
            },
            size: {
                pieInnerRadius: "80%"
            },
            data: {
                sortOrder: "label-asc",
                content: [
                  { label: "JavaScript", value: 1 },
                  { label: "Ruby", value: 2 },
                  { label: "Java", value: 3 },
                  { label: "C++", value: 2 },
                  { label: "Objective-C", value: 6 }
                ]
            }
        });
        </script>

@endsection
