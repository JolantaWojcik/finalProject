<?php
class Config {
	public static function get($path = null) { //we have one static method here, which is called get, inside get we define path and default value is set as null, just that we can check if it exists
		if($path) { // inside of here we want to make sure that the path has been passed to this method
			$config = $GLOBALS['config'];// variable to define where our configs are coming from, just that we can make things easier. Now we have variable config thta we can use later and we don't have to reapet the whoel expression
			$path = explode('/', $path);// the path is the path that's going to be passed in. The path we want to explode, explode is going to take character that we are going to explode by "/". And it's going to give us an array back
			foreach($path as $bit) {//we want to loop through these pieces that we have broken up. We create foreach loop to loop each element of this path array. As bit mean that we have now access to each of the bits that we've defined
				if(isset($config[$bit])) { //we want to check if these are set in the config. Isset - language construct.
					$config = $config[$bit]; // we're setting the config to the bit that we want
				}
			}
			return $config;
		}
	}
}
