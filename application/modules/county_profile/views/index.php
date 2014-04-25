<style>
.datepicker{z-index:1151 !important;}
</style>

<div class="row">
	<div class="map">
	
	<div class="outer">
	<h3>County Data</h3>
	*Click on a County to View Data
		<div class="inner" id="map">
					<script>
var map= new FusionMaps ("assets/fusionmaps/Maps/FCMap_KenyaCounty.swf","KenyaMap","100%","100%","0","0");
map.setJSONData(<?php
echo $maps; ?>
	);
	map.render("map");
					</script>
					<!--div class="content-separator"></div-->
				
			
		</div>
			<div style="width:130px;margin-left:30%;padding:2%"><div style="display:inline-block;width:10px;height:10px;background:#FFCC99"></div><div style="width:80px;display:inline-block;margin-left:5px;font-size:120%">Targeted Site</div></div>
	</div>

	<div class="outer">
	<div class="inner-mini">
			<div class="stat" id="county">
				<span class="text"></span><span class="digit"></span>
			</div>		
			<div class="stat" id="under5">
				<div class="icon" style="display:none" ><i class="fa fa-users"></i></div>
				<div>
					<span class="text"></span>
					<span class="digit"></span> 
				</div>
			</div>
			<div class="stat" id="women">
				<div class="icon" style="display:none"><i class="fa fa-users"></i></div>
				<div>
					<span class="text"></span>
					<span class="digit"></span>
				</div>
			</div>
			
		</div>
	</div>
	</div>
	<div class="standard-graph-lg">
	
	<div class="outer">
	<h3>Service Provision<i id="service_link" class="fa fa-external-link" data-toggle="tooltip" data-placement="bottom" title="Click for More"></i></h3>
	<div class="inner">
			<div class="summary"><span class="text">Trainers Trained</span><span class="digit"><?php echo $tot_number ?></span></div>
			<div class="summary"><span class="text">Latest Training</span><span class="digit"><?php echo $latest_training ?></span></div>
			<div id="imci_training">
				<div class="la-anim-1-mini"></div>
			</div>
		
		</div>
	</div>
	<div class="outer">
	<h3>Demand Generation</h3>
	<div class="inner">
			
			
		</div>
	</div>
	
		
	</div>
	<div class="standard-graph-lg">
	
	<div class="outer">
	<h3>Assessment</h3>
	<div class="inner">
			<div class="summary"><span class="text">Baseline</span> <span id="baseline_total_mnh" class="digit"></span><span class="digit divider" style="color:#000000;margin:0 5px 0 5px">|</span><span class="digit" id="baseline_total_ch"></div>
			<div class="summary">Midterm</span><span></span></div>
			
		</div>
	</div>
	<div class="outer">
	<h3>Commodity Availability</h3>
	<div class="inner">
			
			
		</div>
	</div>
		
	</div>

</div>

<script>
function run(data){
	$('.stat div').show();
	newData=data.split(',')
	$('#county').text(newData[0]);
	$('#under5 .text').text('Childen Under Five Years');
	$('#under5 .digit').text(newData[1]);
	$('#women .text').text('Women of Reproductive Age');
	$('#women .digit').text(newData[2]);
}

$('#baseline_total_mnh').load('<?php echo $this -> config -> item('project_url');?>/c_analytics/getTotalCounties/mnh');
$('#baseline_total_ch').load('<?php echo $this -> config -> item('project_url');?>/c_analytics/getTotalCounties/ch');

$('#imci_training').load('<?php echo base_url(); ?>imci/imci_training_county');

$('#baseline_total_mnh').delay(4000).queue(function(nxt) {
	$('#baseline_total_mnh').append('(MNH)');	
	$('#baseline_total_ch').append('(CH)');	
	nxt();

$('#service_link').click(function(){
	window.open('<?php echo base_url();?>imci',"_parent");
  
});
});

	
</script>
