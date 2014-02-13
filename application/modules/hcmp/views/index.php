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
	<div class="col-md-3">
		<div class="inner">
			<h4>System Usage</h4>
			<div id="hcmp_log">
				<div class="la-anim-1-mini"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h4>Lead Time</h4>
			<div id="lead_time">
				<div class="la-anim-1-mini"></div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h4>County Sensitization</h4>
			<div id="hcmp_sensitization">
				<div class="la-anim-1-mini"></div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="inner">
			<h4>...</h4>

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
<!-- Add Event modal -->
<div class="modal fade" id="hcmp_manual_update" >
	<div class="modal-dialog" style="width:80%" >

		<div class="modal-content">
			<?php echo form_open('hcmp/manual_entry'); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Update Activity</h4>
			</div>
			<div class="modal-body" style=" height:60%;overflow-y:scroll">
				
				<table id="activity_table" class="table-bordered table-striped" >
					<thead>
						<tr style="font-size:1em">
							<th>NAMES OF PARTICIPANT</th><th>WORK STATION</th><th>MFL CODE</th><th>CADRE</th><th>ID NUMBER</th>
							<th>MOBILE NUMBER</th><th>EMAIL ADDRESS</th><th>DATES</th><th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr row_id="0">
							<td>
								<input type="text" value="" name="names_of_participant[]" required aria-required="true" pattern="[A-Za-z]+\s[A-Za-z]+" title="Firstname Lastname" class="form-control participant" placeholder="Person Responsible..." >
							</td>
							<td>
								<input type="text" value="" name="work_station[]" required aria-required="true" title="" class="form-control workstation" placeholder="e.g Kenyatta..." >
							</td>
							<td>
								<input type="text" value="" name="mfl_code[]" pattern="[0-9]{1,5}"  required aria-required="true" class="form-control mfl_code" placeholder="e.g 12345" >
							</td>
							<td>
								<input type="text" value="" name="cadre[]" required aria-required="true" class="form-control cadre" placeholder="e.g Nurse/Midwife" >
							</td>
							<td>
								<input type="text" value="" name="id_number[]" pattern="[0-9]{1,10}" title="Numbers Only" required aria-required="true" class="form-control id_number" placeholder="e.g 23456789..." >
							</td>
							<td>
								<input type="text" value="" name="mobile_number[]" pattern="[0-9]{10}" title="Numbers Only,10 digits" required aria-required="true" class="form-control mobile_number" placeholder="e.g 0712345678" >
							</td>
							<td>
								<input type="email" value="" name="email_address[]" required aria-required="true" class="form-control email_address" placeholder="e.g user@example.com" >
							</td>
							<td>
								<input type="text" value="" name="dates[]" required aria-required="true" class="form-control datepicker"  >
							</td>
							<td>
								<a class="btn-xs btn-danger remove">Remove</a>
							</td>
						</tr>
					</tbody>
				</table>
			<input type="hidden" id="activity_id_man"name= "activity_id_man">
			</div>
			<div class="modal-footer" style="height:45px">
				<button class="add btn btn-primary" >Add Row</button>
				<button id="manual-entry" type="submit" class="btn btn-primary">
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
		$('.la-anim-1-mini').addClass('la-animate');
		$('#hcmp_log').load('<?php echo base_url();?>hcmp/hcmp_log/2013-09');
		$('#lead_time').load('<?php echo base_url();?>hcmp/hcmp_lead_time');
		$('#hcmp_sensitization').load('<?php echo base_url();?>hcmp/hcmp_sensitization');
		
		$(".add").click(function() {
		//	when add is clicked this function
 $('.datepicker').datepicker('remove');

		$table=$('#activity_table');
		var cloned_object=$table.find('tr:last').clone(true);

		var row_id = cloned_object.attr("row_id");
		var next_row_id = parseInt(row_id) + 1;
		

		cloned_object.attr("row_id",next_row_id );
		cloned_object.find("input").val("");
	    //cat_name;
	   //  cat_name.attr("text",'');
		//cloned_object.find(".participant").attr("name",'participant['+next_row_id+']');

		cloned_object.insertAfter('#activity_table tr:last');
		$('.remove').show();
		
 $('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose:true
});

		return false;
		});	
		
		$('.remove').click(function(){
		id = $(this).parent().parent().attr("row_id");
		if(id!=0){
			$(this).parent().parent().remove();
		}
		else{
			alert('This is the first row');
		}
			
	});
	
	$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose:true
});
	
	
	});
</script>
