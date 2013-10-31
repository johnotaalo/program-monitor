<?php
	/*
	 * Loop through all the menus available to this user!
	 * Fetch the current domain
	 * Check if current is equal to the default home controller then set home as active
	 */
	$menus = array("Schedule"=>"c_admin","Movies"=>"c_main");
	$current = $this -> router -> class;
	$counter = 0;
	if($menus){?>
		<a href="<?php echo site_url('c_home');?>" class="top_menu_link  first_link
		<?php
		if ($current == "c_home") {
			echo " top_menu_active ";
		}
		?>
		"><i class="icon-home"></i>Home </a>
	<?php
	}
?>




<!--Check if current is equal to the other menu_url's then set that url as active-->
<?php
	if($menus){
		foreach($menus as $index=>$menu){?>
		<a href = "<?php echo site_url($menu);?>" class="top_menu_link
			<?php
			if ($current == $menu || $menu == $link) {
				echo " top_menu_active ";
			}
			?>"> <?php echo $index;?></a><?php
			$counter++;
	 	}
	}
	if($menus){
	?>
	<!--Add Last menu options-->
	<div  class="btn-group" id="div_profile">
		<a href="#" class="top_menu_link btn dropdown-toggle" data-toggle="dropdown"  id="my_profile"><i class="icon-user icon-black"></i> Profile <span class="caret"></span></a>
		<ul class="dropdown-menu" id="profile_list" role="menu">
			<li>
				<a href="#edit_user_profile" data-toggle="modal"><i class="icon-edit"></i> Edit Profile</a>
			</li>
			<li id="change_password_link">
				<a href="#user_change_pass" data-toggle="modal"><i class=" icon-asterisk"></i> Change Password</a>
			</li>
		</ul>
	</div>
	
	<div class="welcome_msg">
		<span>Welcome <b style="font-weight: bolder;font-size: 20px;">Admin</b>. <a id="logout_btn" href="<?php echo base_url().'c_main' ?>"><i class="icon-off"></i>Logout</a></span>
		<br>
		<span class="date"><?php echo date('l,jS-M-Y')
			?></span>
		<input type="hidden" id="facility_hidden" />
	</div> 
<?php 
	}
	?>
