
<nav class="project-nav" role="navigation" id="myBar">
	<a id="setCollapse"href="javascript:;" class="navbar-toggle collapsed"><i class="fa fa-list-ul"></i> </a>
	<!-- Brand and toggle get grouped for better mobile display -->

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="navbar-collapse collapse" id="">
		<a class="navbar-brand"> <?php echo $brand
		?></a>
		<ul class="nav navbar-nav">
			<li>
				<a class="run-anim" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>county_profile">County Profile</a>
			</li>
			<li class="dropdown">
				<a href=""class="dropdown-toggle" data-toggle="dropdown">Sub-Programs<b class="caret"></b></a>
				<ul class="dropdown-menu">	
					<li class="dropdown-submenu">
						<a tabindex="-1" href="#">Assessment</a>
						<ul class="dropdown-menu">
							<li>
								<a class="run-anim" href="#" data-anim="la-anim-1" tabindex="-1" data-link="<?php echo base_url(); ?>baseline">Baseline</a>
							</li>			
							
						</ul>
						<li class="divider"></li>
					</li>	
					<li class="dropdown-submenu">
						<a tabindex="-1" href="#">Demand Generation - Caregiver</a>
						<ul class="dropdown-menu">
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>merchendise">Merchendise</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>print_media">Print Media</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>mass_media">Mass Media</a>
							</li>
							
						</ul>
						<li class="divider"></li>
					</li>		
					<li class="dropdown-submenu">
						<a tabindex="-1" href="#">Service Provision</a>
						<ul class="dropdown-menu">
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>imci">IMCI Training</a>
							</li>
								<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>imci_followup">IMCI Follow Up & Certification (after 6 weeks)</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>imci_mentorship">IMCI Mentorship</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>iccm">ICCM</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>ort">ORT</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>community_strategy">Community Strategy</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>guidelines_policy">Guidelines and Policy Orientation</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>diarrhoea_management_cmes">Diarrhoea Management CMEs</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>health_talks">Health Talks</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>outreaches">Outreaches</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>support_supervision">Support Supervision</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>distribution_of_materials">Distribution of Materials</a>
							</li>
						
							
							
						</ul>
						<li class="divider"></li>
					</li>		
					<li class="dropdown-submenu">
						<a tabindex="-1" href="#">Commodity Availability</a>
						<ul class="dropdown-menu">
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>procurement">Procurement</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>bundling">Bundling</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>redistribution">Redistribution</a>
							</li>
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>quantification_forecasting">Quantification & Forecasting</a>
							</li>
							<li>
								<a class="run-anim" href="#" data-anim="la-anim-1" tabindex="-1" data-link="<?php echo base_url(); ?>hcmp">HCMP</a>
							</li>
							
							
							
						</ul>
						<li class="divider"></li>
					</li>
					<li class="dropdown-submenu">
						<a tabindex="-1" href="#">Private Sector</a>
						<ul class="dropdown-menu">
							<li>
								<a class="run-anim" tabindex="-1" href="#" data-anim="la-anim-1" data-link="<?php echo base_url(); ?>procurement">Procurement</a>
							</li>
							
							
						</ul>
					</li>	
					
					
				</ul>
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<div class="navbar-form navbar-left">
				<?php echo date('l, d M Y');
				?>

				<!--button id="addEvent" class="btn btn-primary">
				<i class="fa fa-plus"></i>Add Event
				</button-->
			</div>

		</ul>
	</div>

</nav>

