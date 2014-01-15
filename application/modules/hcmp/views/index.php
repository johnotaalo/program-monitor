<div class="row">
	<div class="col-md-8">
		<div class="inner">
			<h3>Update Activities</h3>
			<?php echo $activity_table; ?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="inner">
			<h3>Guide</h3>
			<ul>
				<li>
					Click on <b>Manual Entry</b> to update data per form.
				</li>
				<li>
					Click in <b>Upload</b> to upload an Excel Sheet in the following <u><i>Format</i></u>:
				</li>
				<table class="table-bordered">
					<tr style="font-size:14px">
						<th>NAMES OF PARTICIPANT</th><th>WORK STATION</th><th>MFL CODE</th><th>CADRE</th><th>ID NUMBER</th>
					</tr>
					<tr style="margin-top:10px;font-size:14px">
						<th>MOBILE NUMBER</th><th>EMAIL ADDRESS</th><th>DATES</th><th>TRAINING</th>
					</tr>
				</table>
			</ul>

		</div>
	</div>

</div>
<div class="row">
	<div class="col-md-4">
		<div class="inner">
			<h3>System Usage</h3>
			<div id="hcmp_log"></div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="inner">
			<h3>...</h3>
			

		</div>
	</div>

</div>

<script>
	$(document).ready(function(){
		$('#hcmp_log').load('<?php echo base_url();?>hcmp/hcmp_log/2013-09');
	});
</script>
