<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<!--Load Header-->
		<?php $this -> load -> view('header_v'); ?>
	</head>
	<body>
		<!--Load Content-->
		<?php $this -> load -> view($content_view); ?>

		<!--Load footer-->

		<div id="footer">
			<?php $this -> load -> view('footer_v'); ?>
		</div>

	</body>
</html>