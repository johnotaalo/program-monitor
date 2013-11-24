<script src="<?php echo base_url().'assets/scripts/jquery-1.10.2.min.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/bootstrap/bootstrap.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/scripts/modernizr.js'?>"></script>
<script>
	$(document).ready(function() {

		$("#addEvent").click(function() {
			$('#addEventModal').modal('show');
		});
		$("li.gantt-label").hover(function() {
			$('li.gantt-label').popover('toggle');
		});
		$(".gantt-block-label").hover(function() {
			$('.gantt-block-label').popover('toggle');
		});

		$("span.gantt-block").click(function() {
			$('#data').modal('show');

			$('#data').delay(4000).queue(function(nxt) {
				//$("#event_name").text();
				nxt();
			});

		});

	}); 
</script>