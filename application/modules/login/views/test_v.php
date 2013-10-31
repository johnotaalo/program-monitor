<div id="signup_form">
	<div class="short_title" >
		Login 
	</div>
	<form class="login-form" action="<?php echo base_url().'user_management/authenticate'?>" method="post" style="margin:0 auto " >
		<label> <strong >Please Enter Your Email/Username</strong>
			<br>
			<input type="text" name="username" class="input-xlarge" id="username" value="" placeholder="user@example.com">
		</label>
		<label> <strong >Password</strong>
			<br>
			<input type="password" name="password" class="input-xlarge" id="password" placeholder="********">
		</label>
		<input type="submit" class="btn" name="register" id="register" value="Login" >
		<div style="margin:auto;width:auto" class="anchor">
			<strong><a href="<?php echo base_url().'user_management/resetPassword' ?>" >Forgot Password?</a></strong>
		</div>
	</form>
</div>
