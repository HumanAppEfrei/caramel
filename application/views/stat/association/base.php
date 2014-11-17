<!-- HTML --> 
<div id="example-section4">
    <div id="flotcontainer" style="width: 600px;height:200px; text-align: center; margin:0 auto;"> </div> 
</div> 
<!--</div>
<!-- Javascript --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script src="http://www.pureexample.com/js/flot/excanvas.min.js"></script> 
<script src="http://www.pureexample.com/js/flot/jquery.flot.min.js"></script> 
<script type="text/javascript">
    function generateSeries(added) {
        var data = [];
        var start = 100 + added;
        var end = 200 + added;
        for (i = 1; i <= 200; i++) {
            var d = Math.floor(Math.random() * (end - start + 1) + start);
            data.push([i, d]);
            start++;
            end++;
        }
        return data;
    }

    $(document).ready(function() {
        var dataLarge1 = generateSeries(0);
        var dataLarge2 = generateSeries(300);
        $.plot($("#example-section4 #flotcontainer"), [{label: "data1", data: dataLarge1}, {label: "data2", data: dataLarge2}], {grid: {backgroundColor: {colors: ["#D1D1D1", "#7A7A7A"]}}, xaxis: {ticks: 20}, yaxis: {ticks: 10}});
    });
</script>