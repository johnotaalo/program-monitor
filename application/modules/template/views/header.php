<nav class="navbar navbar-default" role="navigation" id="myBar">
	<a id="setCollapse"href="javascript:;" class="navbar-toggle collapsed"><i class="fa fa-list-ul"></i> </a>
	<!-- Brand and toggle get grouped for better mobile display -->

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="navbar-collapse collapse" id="">
		<a class="navbar-brand"> <?php echo $brand ?>
		</a>
		<ul class="nav navbar-nav">
			<li >
				<a class="" href="<?php echo base_url(); ?>">Home</a>
			</li>
			<li class="dropdown">
				<a href=""class="dropdown-toggle" data-toggle="dropdown">Sub-Programs<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php echo $this -> sub_program_list; ?>
				</ul>
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<div class="navbar-form navbar-left">
				<?php echo date('l, d M Y')
				?>

				<!--button id="addEvent" class="btn btn-primary">
				<i class="fa fa-plus"></i>Add Event
				</button-->
			</div>

		</ul>
	</div>

</nav>