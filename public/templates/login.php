<form action="" method="post"> //we outline the form that we're going to create, which is going to allow them to enter their credentials they need to sign in. Action is blank so we submit back to this page.
	<div class="field"> //now we crate similar markup as in Registration
		<label for="username">Login</label>
		<input type="text" name="login" id="login" autocomplete="off">
	</div>
	
	<div class="field">
		<label for="haslo">Haslo</label>
		<input type="password" name="haslo" id="haslo" autocomplete="off">
	</div>
	
	<div class="field">
		<label for="remember"> //text is clickable because we take input in the lable
			<input type="checkbox" name="remember" id="remember"> Remember me
		</label>
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Log in">
	</form>
	
	
	
	
