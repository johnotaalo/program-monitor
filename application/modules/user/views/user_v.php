<div class="center-content">
	<div>
		<ul class="breadcrumb">
			<li>
				<a href="<?php echo base_url().'home' ?>"id='home'><i class="icon-home"></i><strong style="color:#FFF">Home</strong></a>
				<span class="divider"></span>
			</li>
			<li class="active" id="actual_page"><?php echo $actual_page; ?></li>
		</ul>
	</div>
	<?php
	echo $tables;
	?>
</div>