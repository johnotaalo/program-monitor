<script>
$(function () {
var dataSource = <?php echo $dataSource;?>;

$("#<?php echo $container?>").dxChart({
    dataSource: dataSource,
  	commonSeriesSettings: {
        argumentField: <?php echo $argument?>,
        type: <?php echo $type?>,
         label: {
            visible: true,
            connector: {
                visible: true
            },
            customizeText: function(value){
            	return value.valueText ;
        	}
        }    
        
    },
    series: <?php echo $series;?>,
    argumentAxis:{
     	type: 'continuous',
        axisDivisionFactor: 1000
    },
    tooltip:{
        enabled: true,
        customizeText: function(value){
            return value.valueText +' '+ value.seriesName+' in '+ value.argumentText;
        }
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