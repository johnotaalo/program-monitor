<!--Top Panel for menus-->
<div id="top-panel">
	<!--Logo Image-->
	<div class="logo"></div>
	<!--System Custom Title-->
	<div id="system_title">
		<?php
		$this -> load -> view('banner_v');
		?>
		<div id="facility_name">
			<span class="firm_name">I-Max Nairobi</span>
		</div>
	</div>
	<!--Menu-->
	<div id="top_menu">
		<?php $this -> load -> view('menu_v');?>
	</div>
	
</div>

<!--Load footer-->
		<div id="bottom_ribbon">
			<div id="footer">
				<?php //$this -> load -> view('footer_v');?>
			</div>
		</div>