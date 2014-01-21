<script>
$(function () {
var dataSource = <?php echo $dataSource;?>;

$("#<?php echo $container;?>").dxChart({
    dataSource: dataSource,
  
    series: <?php echo $series;?>,
    argumentAxis:{
        grid:{
            visible: false
        }
    },
    tooltip:{
        enabled: true,
        customizeText: function(value){
            return value.valueText +' in '+ value.argumentText;
        }
    },
    //title: "Historic, Current and Future Population",
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center",
       visible:<?php echo $legendVisible?>
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
<div id="<?php echo $container;?>" class="graph" style="height:80%">
	
</div>