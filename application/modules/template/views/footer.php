
<script src="<?php echo base_url().'assets/scripts/datatables/paging.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/modernizr.js'?>"></script>

<script src='<?php echo base_url(); ?>assets/scripts/globalize.min.js'></script>


<script>
	$(document).ready(function() {

		$("#addEvent").click(function() {
			$('#addEventModal').modal('show');
		});
		
		
		
		$(".activity_update").click(function() {
			$('#update_activity').modal('show');
		});
		
		
		
		$("li.gantt-label").hover(function() {
			$(this).popover('toggle');
		});
		$(".gantt-block-label").hover(function() {
			$(this).popover('toggle');
		});

		$("strong.gantt-block-label").click(function() {
			$('#data').modal('show');
			blockID = $(this).attr("id");
			$('#data').delay(2000).queue(function(nxt) {
				$("#eventName").val(blockID);
				nxt();
			});

		});
		
			$('.dataTable').dataTable({
		 "sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>"
	});
	
	/*$().();
	$().(function(){
	
	});*/
$('.dataTables_filter label input').addClass('form-control');
$('.dataTables_filter').addClass('form-inline');
$('.dataTables_length').addClass('form-inline');
$('.dataTables_length select').addClass('form-control');
	
		
		

	}); 
</script>