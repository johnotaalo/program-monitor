<div class="row">
	<div class="col-md-9">
		<div class="inner">
			<h3>Update Activities</h3>
			<?php echo $activity_table; ?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h3>Guide</h3>
			<ul>
				<li>
					Click on <b>Manual Entry</b> to update data per form.
				</li>
				<li>
					Click in <b>Upload</b> to upload an Excel Sheet in the following <u><i>Format</i></u>:
				</li>
				<table class="table-bordered" style="width:95%">
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
	<div class="col-md-3">
		<div class="inner">
			<h4>Coverage by Cadre</h4>
			<div id="imci_cadre"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h4>...</h4>
			<div id="summary"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">

		</div>
	</div>
		<div class="col-md-3">
		<div class="inner">

		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#imci_cadre').load('<?php echo base_url();?>imci/imci_cadre');
	});
</script>