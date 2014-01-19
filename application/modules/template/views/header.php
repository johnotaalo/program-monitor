<nav class="navbar navbar-default" role="navigation" id="myBar">
	<a id="setCollapse"href="javascript:;" class="navbar-toggle collapsed"><i class="fa fa-list-ul"></i> </a>
	<!-- Brand and toggle get grouped for better mobile display -->

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="navbar-collapse collapse" id="">
		<a class="navbar-brand"> <?php echo $brand
		?></a>
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href=""class="dropdown-toggle" data-toggle="dropdown">Sub-Programs<b class="caret"></b></a>
				<ul class="dropdown-menu">					
					<li class="dropdown-submenu">
						<a tabindex="-1" href="#">Commodity Management</a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo base_url(); ?>hcmp">HCMP</a>
							</li>
							<li>
								<a tabindex="-1" href="<?php echo base_url(); ?>bundling">Bundling</a>
							</li>
							
						</ul>
						<li class="divider"></li>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>imci">IMCI</a>
					</li>
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