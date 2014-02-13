<div class="row">
	<div class="col-md-3">
		<div class="inner">
			<h3>Most Unavailable Equipment</h3>
			<div id="unavailability_rank">
				<div class="la-anim-1-mini"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner guide">
			<h3>CH Reporting Rate</h3>
			<div class="reporting" id="ch_reporting">
				<div class="la-anim-1-mini"></div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="inner guide">
			<h3>MNH Reporting Rate</h3>
			<div class="reporting" id="mnh_reporting">
				<div class="la-anim-1-mini"></div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="inner guide">
		
			

		</div>
	</div>

</div>

<script>
	$(document).ready(function(){
		$('#unavailability_rank').load('<?php echo base_url();?>baseline/unavailable_equipment_rank');
		$('#ch_reporting').load('<?php echo $this -> config -> item('project_url');?>/c_analytics/getAllReportedCounties/ch');
		$('#mnh_reporting').load('<?php echo $this -> config -> item('project_url');?>/c_analytics/getAllReportedCounties/mnh');
	});
</script>
