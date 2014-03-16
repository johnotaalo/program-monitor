<script>
$(function () {
var dataSource = <?php echo $dataSource;?>;

$("#<?php echo $container;?>").dxPieChart({
  
    dataSource: dataSource,
    commonSeriesSettings: {
        label: {
            visible: true,
            connector: {
                visible: true
            },
            customizeText: function(value){
            	return value.argumentText ;
        	}
        }        
        //...
    },
    series: <?php echo $series;?>,
    tooltip:{
        enabled: true,
        customizeText: function(value){
            return value.argumentText+' ' +value.percentText;
        }
    },
    legend: {
        visible:false
   	}
});
});
</script>
<div id="<?php echo $container;?>" class="graph" style="height:90%">
	
</div>