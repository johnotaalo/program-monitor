<script>
$(function () {
$('#<?php echo $container;?>').dxLinearGauge({
	scale: {
		startValue: 0, endValue: <?php echo $endValue?>,
		majorTick: {
			color: '#536878',
			tickInterval: 5
		},
		label: {
			indentFromTick: -3
		}
	},
	rangeContainer: {
		offset: 10,
		ranges: <?php echo $ranges?>
	},
	valueIndicator: {
		offset: 20
	},
	subvalueIndicator: {
		offset: -15
	},
	value: <?php echo $value?>,
	subvalues: [5, 25]
});
});
</script>
<div id="<?php echo $container;?>" class="graph" style="height:90%">
	
</div>