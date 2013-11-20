<!-- modal -->
<div class="modal fade" id="data" >
	<div class="modal-dialog" style="width:90%">
		<div class="modal-content">
			<?php echo form_open('upload'); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">File contents:</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer" style="height:45px">
				<button type="button" class="btn btn-primary">
					<i class="glyphicon glyphicon-upload"></i> Upload Data
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class="glyphicon glyphicon-remove-circle"></i> Close
				</button>
			</div>
			<?php   echo form_close(); ?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
