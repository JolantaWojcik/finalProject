<?php 
class Input {
	public static function exists($type = 'post') { //method that ckecks if any data actually exists, so if input has been provided or not. Deafult is 'post' so if we don't define get specifically, it would check if the post data has been provided or not
		switch($type) { // we are going to switch on type and next we are checking on few cases
			case 'post':
				return (!empty($_POST)) ? true : false; //if not empty, then echo/return true, otherwise return false
			break;
			case 'get':
				return (!empty($_GET)) ? true : false;
			break;
			default:
				return false; // it is false because we assume that we always should get data
			break;
		}
	}
	
	public static function get($item) {  /second method is going to basically retrieve an item; item to nazwa pola w formularzu np username
		if(isset($_POST[$item])) { // we're checking for post data first
			return $_POST[$item]; //if that's available we're going to return that item
		}
		if(isset($_GET[$item])) {
			return $_GET[$item];
		}
		return ''; // by default we want to return an empty string. So if above data doesn't exists we still want to retirn sth back
	}

}

?>
