<script src="<?php echo base_url().'assets/scripts/jquery-1.10.2.min.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/bootstrap/bootstrap.min.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/modernizr.js'?>"></script>
<script>
	$(document).ready(function() {
$('#upload_button').change(function(){
	if($('#upload_button').val()!=''){
		$('#data').modal('show');
	}
	$("#upload_form").submit();
});
/*$(".upload").click(function(){
	alert("sdhvgikl")
});*/

	}); 
</script>