<?php
$formAttr=array('enctype'=>'multipart/form-data','name'=>'upload_form','id'=>"upload_form");;
echo form_open('trainings/upload', $formAttr);
?>
<label>Training Type</label>
<?php echo form_error('training_type'); ?>
<div class="input-group">
	<span class="input-group-addon"><i class="fa"></i></span>
	<select name="item_name" type="text" class="form-control"><?php echo $this -> training_list; ?></select>
</div>
<label>Training Sign Sheet</label>
<?php echo form_error('training_sign_sheet'); ?>
<div class="input-group">
	<?php $btnAttr = array('id'=>'upload_button','class'=>'btn btn-default','name'=>'file_1');
	echo form_upload($btnAttr);?>
</div>

<button form-action="submit" class="btn btn-primary">
	Add
</button>
<?php echo form_close(); ?>