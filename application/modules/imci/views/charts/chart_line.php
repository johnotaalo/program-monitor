<script>
$(function () {
var dataSource = <?php echo $dataSource;?>;

$("#chartContainer").dxChart({
    dataSource: dataSource,
  
    series: <?php echo $series;?>,
    argumentAxis:{
        grid:{
            visible: false
        }
    },
    tooltip:{
        enabled: true
    },
    //title: "Historic, Current and Future Population",
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    commonPaneSettings: {
        border:{
            visible: true,
            right: false
        }       
    }
});
});
</script>
<div id="chartContainer" class="graph" style="height:90%">
	
</div>