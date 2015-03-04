<?php
class Session {
	public static function exists($name) { // the ability to check if the particular session exists
		return(isset($_SESSION[$name])) ? true : false; // if a token is set true, otherwise false
	}
	// we use this part for token:
	public static function put($name, $value) { // we want to put session name and the session value
		return $_SESSION[$name] = $value; // we return the value of the session
	}
	//ability to get a particular value:
	public static function get($name) {
		return $_SESSION[$name];
	}
	// ability to delete a token:
	public static function delete($name) {
		if(self::exists($name)) { // we want to refer whether the token actually exists or not, as we don't want to unset anything that doesn't exist
			unset($_SESSION[$name]); //we unset it if it exists
		}
	}
	// ability to flash data with the session:
	public static function flash($name, $string = '') {
		if(self::exists($name)) {//we check if the session exists
		// then we want to set the value that we return to the session data that we've set, return it and also delete it.
			// so we're like creating a message, giving ourselves the ability to show it on our screen and then delete it, so the next time user refreshes the page, the message goes.
			//Np. jak user sie rejestruje i chcemy go przeniesc do homepage i napisac ze sie udalo mu zarejestrowac, to nie chcemy zeby po odswierzeniu ta wiadomosc znowu sie pojawila.
			$session = self::get($name); // we want to store the session in this variable
			self::delete($name); // we delete the session
			return $session;
		} else { // otherwise we want to set the data
			self::put($name, $string);
		}
	}
}
