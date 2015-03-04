<?php
class Token {
	public static function generate() {  //token, md5(uniqid)// we create a static method to generate a token for us
		return Session::put(Config::get('session/token_name'), md5(uniqid())); //we have to build Session class!!!
	}
	// now we need the ability to check if the token exists or not
	// so we also need an ability to get a token from our session and check if it's the same as the token defined in the form
	public static function check($token) { // we want to check if the token exists in this session
		$tokenName = Config::get('session/token_name');
		
		// If the token equals the session that's currently being applied /if the token is being applied in the session/,
		//then we want to delete that session, return true if that's the case.
		
		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName); // we delete the session by token name
			return true;
		}
		
		return false;
	}
}
