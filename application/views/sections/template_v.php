<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<!--Load Header-->
		<?php $this -> load -> view('sections/header_v');?>
	</head>
	<body>
		<!--Top Panel for menus-->
		<div id="top-panel">
			<!--Logo Image-->
			<div class="logo"></div>
			<!--System Custom Title-->
			<div id="system_title">
				<?php
				$this -> load -> view('sections/banner_v');
				?>
				<div id="facility_name">
					<span class="firm_name">I-Max Nairobi</span>
				</div>
			</div>
			<!--Menu-->
			<div id="top_menu">
				<?php $this -> load -> view('sections/menu_v');?>
			</div>
		</div>
		<!--Load Content-->
		<?php $this -> load -> view($content_view);?>

		<!--Load footer-->
		<div id="bottom_ribbon">
			<div id="footer">
				<?php $this -> load -> view('sections/footer_v');?>
			</div>
		</div>
	</body>
</html>