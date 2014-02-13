<html>
	<head>
		<?php $this -> load -> view('head'); ?>
	</head>
	<body>
		<div class="la-anim-1"></div>
		<div id="header">
			<?php $this -> load -> view('header'); ?>
		</div>
		<div id="contentView">
			<?php $this -> load -> view($contentView); ?>
		</div>
		<div id="footer">
			<?php $this -> load -> view('footer'); ?>
		</div>
		<?php $this -> load -> view('modals'); ?>
	</body>
</html>