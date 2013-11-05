<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<!--Load Header-->
		<?php $this -> load -> view('header_v'); ?>
	</head>
	<body>
		<!--Load Menu-->
		<?php if($show_menu==1){
			$this -> load -> view('toppanel_v');
		}?>
		
		<!--Load Content-->
		<?php $this -> load -> view($content_view); ?>

		<!--Load footer-->

		<div id="footer">
			<?php $this -> load -> view('footer_v'); ?>
		</div>

	</body>
</html>