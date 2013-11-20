<div id="upload">
	<h3>Upload File</h3>
<div class="inner">
	<?php
	echo form_open();
	echo form_upload('pimaUpload', 'Pima upload', 'class="btn btn-default"','id="upload_button"');

	//echo form_button('viewData', '<i class="glyphicon glyphicon-list"></i> View Data', 'onclick="viewData()" class="btn btn-default btn-minii"');
	echo form_close();
	?>
	</div>
</div>
