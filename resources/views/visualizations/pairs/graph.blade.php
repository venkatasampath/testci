@if(!$initialshow)
    <style>
        .viz-biPartite-subBar{
            shape-rendering:crispEdges;
        }
        .viz-biPartite-mainBar rect{
            shape-rendering: auto;
            fill-opacity: 0;
            stroke-width: 0.5px;
            stroke: rgb(0, 0, 0);
            stroke-opacity: 0;
        }
        .edges{
            stroke:none;
            fill-opacity:0.5;
        }
        line {
            stroke: grey;
        }
    </style>
    <body>
    <svg id="bp" width="960" height="700">
        <!-- <g transform="translate(250,75)"></g> -->
    </svg>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="http://vizjs.org/viz.v1.3.0.min.js"></script>
    <script>
        var svg = d3.select("svg");
        //var g = d3.select("g");
        var g = svg.append("g").attr("transform","translate(300,75)")
        var data= {!! json_encode($data) !!};
        //g.call(viz.biPartite().data(data));


        var bp= viz.biPartite()
            .data(data)
            .min(12)
            .pad(1)
            .height(600)
            .width(400)
            .barSize(35);

        g.call(bp);
        g.append("text").attr("x",-100).attr("y",-8).style("text-anchor","middle").text("Left Specimens");
        g.append("text").attr("x", 500).attr("y",-8).style("text-anchor","middle").text("Right Specimens");

        g.append("line").attr("y1",0).attr("y2",0).attr("x1",-200).attr("x2",0);
        g.append("line").attr("y1",0).attr("y2",0).attr("x1",400).attr("x2",600);


        g.selectAll(".viz-biPartite-mainBar")
            .append("text")
            .attr("x",d=>(d.part=="primary"? -70: 70))
            .attr("y",d=>+6)
            .text(d=>d.key)
            .attr("text-anchor",d=>(d.part=="primary"? "end": "start"));

        g.selectAll(".viz-biPartite-mainBar")
            .append("text")
            .attr("x",d=>(d.part=="primary"? -25: 25))
            .attr("y",d=>+6)
            .text( d=>d.value)
            .attr("text-anchor",d=>(d.part=="primary"? "end": "start"));

        svg.append("text").attr("x",450).attr("y",30)
            .attr("class","header").text("Pair Matching");

        d3.select(self.frameElement).style("height", "700px");


    </script>
    </body>




@endif