<div class="signup_wrap">
<div class="signin_form">
	<?php echo form_open("user/login"); ?>
	    <label for="username">Username:</label>
    	<input type="text" id="username" name="username" value="" />
	    <label for="pass">Password:</label>
		<input type="password" id="pass" name="pass" value="" />
        <input type="submit" class="" value="Sign in" />
    <?php echo form_close(); ?>
</div><!--<div class="signin_form">-->
</div><!--<div class="signup_wrap">-->