<div id="upload">
	<h3>Upload File</h3>
<div class="inner">
	<?php
	echo form_open();
	$btnAttr = array('id'=>'upload_button','class'=>'btn btn-default','name'=>'upload_button');
	echo form_upload($btnAttr);

	//echo form_button('viewData', '<i class="glyphicon glyphicon-list"></i> View Data', 'onclick="viewData()" class="btn btn-default btn-minii"');
	echo form_close();
	?>
	</div>
</div>
