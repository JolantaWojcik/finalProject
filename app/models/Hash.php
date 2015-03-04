<?php
class Hash {
	//it's going to make a hash:
	//String must be provided, otherwise it would be a random hash:
	//We also want to apply salt to this, or not, so we're gonna add it as an empty string anyway
	// Salt improves a security of a password hash because it adds a randomly genrated and secure string of data onto the end of password
	//And when we for example log a user in, we can add the salt on to then check whether the hash matches the plaintext password;
	//so we take the plaintext string and add the salt to it, hash that when the user logs in they enter the password, we then append the salt on to that again hashed out and check if it matches the additional at the existing hash.
	//It is more secure because the salt is random.
	public static function make($string, $salt = '') {
		return hash('sha256', $string.$salt);// we apply it as a string but we're going to concatenate on the salt that we provide
	}
	
	public static function salt($lenght) {// we're making a salt
		return mcrypt_create_iv($lenght); //it will provide us with the load of rubbish :-D so we will have a really strong salt
	}
	
	public static function unique() { //it's making a unique hash
		return self::make(uniqid());
	}
	
}
