<?php
require_once('../app/core/Controller.php');

class Login extends Controller {
	
	public function index() {
	if(Input::exists()) { //check if the input actually exists or not, so whether the form has been submitted
		if(Token::check(Input::get('token'))) { //check if the token is correct and has been supplied by the form
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array( // POST supplies the set of data that we want to check the
				'login' => array('required' => true),
				'haslo' => array('required' => true),
			));
			
			if($validate->passed()) {   //check if validation passes
			// if so we want to log the user in:
				$user = new User();		//tworzenie nowego u¿ytkownika user
			// we create a remember variable. And we want to detect whether we have this input remembered, when it equals on or not.	
				$remember = (Input::get('remember') === 'on') ? true : false;   //does it equals on? if it equals on, then we want to pass true otherwise we want to apss false.
				$login = $user->login(Input::get('login'), Input::get('haslo'), $remember); //we process the log in by creating the login value, utilizing the user object and the login method // we pass that through into our login method /remember/
				
				if($login) { //check if the login was successful
					Redirect::to('index.php');
				} else {
					echo "Poda³eœ nieprawid³owe dane!";
				}
			} else {
				foreach($validate->errors() as $error) { //otherwise for each of these errors
					echo $error, "<br>";
				}
			}
		}
	}
	$this->view('login');
	}
}

?>
