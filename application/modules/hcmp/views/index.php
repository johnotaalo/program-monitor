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
			<ul class="guide">
				<li>
					Click on <b>Manual Entry</b> to update data per form.
				</li>
				<li>
					Click in <b>Upload</b> to upload an Excel Sheet in the following <u><i>Format</i></u>:
				</li>
				<table class="table-bordered">
					<tr style="font-size:1.4em">
						<th>NAMES OF PARTICIPANT</th><th>WORK STATION</th><th>MFL CODE</th><th>CADRE</th><th>ID NUMBER</th>
					</tr>
					<tr style="margin-top:10px;font-size:1.4em">
						<th>MOBILE NUMBER</th><th>EMAIL ADDRESS</th><th>DATES</th>
					</tr>
				</table>
			</ul>

		</div>
	</div>

</div>
<div class="row">
	<div class="col-md-6">
		<div class="inner">
			<h4>System Usage</h4>
			<div id="hcmp_log"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h4>Lead Time (Ordering-Update)</h4>
			<div id="lead_time"></div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h4>County Sensitization</h4>
			<div id="hcmp_sensitization"></div>

		</div>
	</div>

</div>
<div class="modal fade" id="hcmp_upload_activity" >
	<div class="modal-dialog">

		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Activity</h4>
			</div>
			<div class="modal-body">
				<?php $this->load->view('forms/upload_training')?>

			</div>
			<div class="modal-footer" style="height:45px">
				<button id="hcmp_uploadActivityBtn" type="submit" class="btn btn-primary">
					<i class="fa fa-plus"></i>Upload 
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times"></i> Close
				</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="hcmp_manual_update" >
	<div class="modal-dialog">

		<div class="modal-content">
			<?php echo form_open(); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Update Activity</h4>
			</div>
			<div class="modal-body">

				<label>Activity Name</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
					<input type="text" class="form-control" >

				</div>

				<label>Progress</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
					<input type="text" class="form-control" placeholder="">

				</div>
				<label>Responsible</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" class="form-control" placeholder="Please Enter Person Responsible..." >

				</div>

			</div>
			<div class="modal-footer" style="height:45px">
				<button id="addEvent" type="submit" class="btn btn-primary">
					<i class="fa fa-plus"></i>Update Activity
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times"></i> Close
				</button>
			</div>
			<?php   echo form_close(); ?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	$(document).ready(function(){
		$(".hcmp_manual_update").click(function() {
			$('#hcmp_manual_update').modal('show');
		});
		$(".hcmp_activity_upload").click(function() {
			$('#hcmp_upload_activity').modal('show');
			activityID = $(this).attr('id');
			$('#upload_button').delay(2000).queue(function( nxt ) {
				$('#activity_id').val(activityID);
				nxt();
			});
			
		});
		$("#hcmp_uploadActivityBtn").click(function() {
			$('#hcmp_upload_form').submit();
		});
		$('#hcmp_log').load('<?php echo base_url();?>hcmp/hcmp_log/2013-09');
		$('#lead_time').load('<?php echo base_url();?>hcmp/hcmp_lead_time');
		$('#hcmp_sensitization').load('<?php echo base_url();?>hcmp/hcmp_sensitization');
	});
</script>
