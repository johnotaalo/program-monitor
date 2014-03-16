<style>
.datepicker{z-index:1151 !important;}
</style>

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
				
			</ul>

		</div>
	</div>

</div>
<div class="row">
	<div class="col-md-6">
		<div class="inner">
			<h4>...</h4>
			
		</div>
	</div>

	<div class="col-md-3">
		<div class="inner">
			<h4>...</h4>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
<h4>...</h4>
		</div>
	</div>
</div>

<div class="modal fade" id="imci_followup_upload_activity" >
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
				<button id="imci_uploadActivityBtn" type="submit" class="btn btn-primary">
					<i class="fa fa-plus"></i>Upload
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times"></i> Close
				</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
		$(document).ready(function(){
			
	$(".imci_followup_activity_upload").click(function() {
	$('#imci_followup_upload_activity').modal('show');
	activityID = $(this).attr('id');
	$('#upload_button').delay(2000).queue(function( nxt ) {
	$('#activity_id').val(activityID);

	nxt();
	});

	});	
	
		
		});
</script>