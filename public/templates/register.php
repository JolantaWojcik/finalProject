<form action="" method="post">
	<div class="field">
	<label for="username">Username</label> //input for username
	<input type="text" name="login" id="login" value="<?php echo escape(Input::get('login')) ?>" autocomplete="off"> //input itself. Autocomplete off so that we don't get brought up any suggestions for us
	</div>
	
	<div class="field">
	<label for="password">Choose a password</label>
	<input type="password" name="haslo" id="haslo">
	</div>
	
	<div class="field">
	<label for="password_again">Choose a password again</label>
	<input type="password_again" name="powtorz_haslo" id="powtorz_haslo">
	</div>
	
	<div class="field">
	<label for="name">Your name</label>
	<input type="text" name="imie" value="<?php echo escape(Input::get('imie')) ?>" id="imie">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>"> //token is generated, value is our token class. Echo... that would be returned to us because we're returning in Token class the value Session put
	<input type="submit" value="Register">
</form>
