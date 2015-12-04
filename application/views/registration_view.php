

<div class="reg_form">
<div class="form_title">Sign Up</div>
<div class="form_sub_title">Join us to sell and buy clothing!</div>
<?php echo validation_errors('<p class="error">'); ?>
	<?php echo form_open("user/registration"); ?>
	<div class="form-group">
		<input type="text" name="user_name" id="user_name" tabindex="1" class="form-control" placeholder="Username" value="<?php echo set_value('user_name'); ?>" />
	</div>
	<div class="form-group">
		<input type="email" name="email_address" id="email_address" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo set_value('email_address'); ?>" />
	</div>
	<div class="form-group">
		<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
	</div>
	<div class="form-group">
		<input type="password" name="con_password" id="con_password" tabindex="2" class="form-control" placeholder="Confirm Password">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Join Now">
			</div>
		</div>
	</div>
<?php echo form_close(); ?>


