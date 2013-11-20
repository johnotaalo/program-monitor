<script src="<?php echo base_url().'assets/scripts/jquery-1.10.2.min.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/bootstrap/bootstrap.min.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/modernizr.js'?>"></script>
<script>
	$(document).ready(function() {
$('#upload_button').click(function(){
	alert($('#upload_button').val());
	$('#data').modal('show');
});

	}); 
</script>