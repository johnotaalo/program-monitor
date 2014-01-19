<div class="row">
	<div class="col-md-3">
		<div class="inner">
			<h3>Most Unavailable Equipment</h3>
			<div id="unavailability_rank"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner guide">
			<h3>...</h3>
			

		</div>
	</div>
	<div class="col-md-6">
		<div class="inner guide">
			<h3>...</h3>
			

		</div>
	</div>

</div>

<script>
	$(document).ready(function(){
		$('#unavailability_rank').load('<?php echo base_url();?>baseline/unavailable_equipment_rank');
		
	});
</script>
