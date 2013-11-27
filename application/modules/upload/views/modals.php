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
			<div class="modal-body" id="dataBody">
				<table class="table table-bordered table-hover table-striped dataTable">
				<?php
				echo '<thead>';
				for($i=0;$i<1;$i++){
					echo '<tr>'.
					'<th width="100px">'.$uploaded['testNO'][$i].'</th>'.
					'<th width="400px">'.$uploaded['deviceID'][$i].'</th>'.
					'<th>'.$uploaded['asayID'][$i].'</th>'.
					'<th>'.$uploaded['sampleNumber'][$i].'</th>'.
					'<th>'.$uploaded['cdCount'][$i].'</th>'.
					'<th>'.$uploaded['resultDate'][$i].'</th>'.
					'<th>'.$uploaded['operatorId'][$i].'</th>'.
					'</tr>';
					
				}
				echo '<thead>';
				echo '<tbody>';
				for($i=1;$i<sizeof($uploaded['testNO']);$i++){
					echo '<tr>'.
					'<td>'.$uploaded['testNO'][$i].'</td>'.
					'<td>'.$uploaded['deviceID'][$i].'</td>'.
					'<td>'.$uploaded['asayID'][$i].'</td>'.
					'<td>'.$uploaded['sampleNumber'][$i].'</td>'.
					'<td>'.$uploaded['cdCount'][$i].'</td>'.
					'<td>'.$uploaded['resultDate'][$i].'</td>'.
					'<td>'.$uploaded['operatorId'][$i].'</td>'.
					'</tr>';
				}
				echo '</tbody>';
				?>
				</table>
			</div>
			<div class="modal-footer" style="height:45px">
				<button type="button" class="btn btn-primary upload">
					<i class="fa fa-arrow-up"></i> Upload Data
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times"></i> Close
				</button>
			</div>
			<?php   echo form_close(); ?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
