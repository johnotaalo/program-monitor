<script>
$(function () {
var dataSource = <?php echo $dataSource;?>;

$("#<?php echo $container;?>").dxPieChart({
  
    dataSource: dataSource,
    label: {
            visible: true,
            connector: {
                visible: true
            }
       },
    series: <?php echo $series;?>,
    tooltip:{
        enabled: true,
        customizeText: function(value){
            return value.percentText ;
        }
    }
});
});
</script>
<div id="<?php echo $container;?>" class="graph" style="height:90%">
	
</div>