<script>
$(function () {
var dataSource = <?php echo $dataSource;?>;

$("#<?php echo $container?>").dxChart({
    dataSource: dataSource,
  	commonSeriesSettings: {
        argumentField: <?php echo $argument?>,
        type: <?php echo $type?>,
        hoverMode: "allArgumentPoints",
        selectionMode: "allArgumentPoints",
        label: {
            visible: <?php echo $label?>,
            format: "fixedPoint",
            precision: 0
        }
    },
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
<div id="<?php echo $container?>" class="graph" style="height:90%">
	
</div>