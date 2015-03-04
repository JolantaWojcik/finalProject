<?php
require_once('../app/core/Controller.php');

class Register extends Controller {
	public function index() {
		if(Input::exists()) { //here we are using Input class. Bracets can be empty, without post, because we now we are automatically resolving to post data from Input class.
			if(Token::check(Input::get('token'))) { // Even if the token in other register class doesn't exist, this will still fail and  therefore this won't work
				$validate = new Validate(); //we've got new object now, so we can perform validtion
				$validation = $validate->check($_POST, array( //we want to check a particular set of data against certain conditions, in this case we want to check POST. We create array that will contain all the rules that we're going to include in our validation. So it basically wil ba the field name of the data that we've included in our form. In this case we will have 4 feild s that we need to validate, which will be arrays as well baceuse we're going to define within the array the rules:
					'login' => array( //next we define the rules that we want to pass through:
						'required' => true, //it is required
						'min' => 2, //minimum 2 character of the username
						'max' => 20, //maximum character 20
						'unique' => 'uzytkownicy', //it avoid us having to create an additional query somewhere inside of this /register/ code. We say it is unique to the uzytkownicy table.
						'pole' => 'pole2'
					),
					'haslo' => array(
						'required' => true,
						'min' => 6,
					),
					'powtorz_haslo' =>array(
						'required' => true,
						'matches' => 'haslo',//it matches the haslo field
					),
					'imie' => array(
						'required' => true,
						'min' => 2,
						'max' => 50,
					)
				));

				// how we want to detect if this/above has passed or not:
				if($validate->passed()) { //register user; we've passed.
				//if we passed, then firstly we want to instantiate the user class. That gives us access to our database, if it's already been connected etc.
					$user = new User();
					
					$salt = Hash::salt(32);//we're generating a hash of lenght 32
					//we want to eneter user data:
					//beacuse we've thrown an exception within that method, we'll be able to catch any problems
						try {
						$user->create(array( //method that we've created in the user object /User.php/; and we have array of fields we want to insert
							// we'll need a Hash class!!!
							// we need to be generating hashes
							//we need to use the hashes or use the salt against the hash
							// store a salt
							'login' => Input::get('login'),
							'haslo' => Hash::make(Input::get('haslo'), $salt),//we're adding the previously done functionality /hash/. It's the user's password that they've defined to us, and we also add salt!
							'salt' => $salt,//here we store the salt!!!! it's very important!!  if we don;t do this the password will be lost. As if we don't know the salt we want to append on to check, we can't compare the original value.
							'imie' => Input::get('imie'),
							'data_utworzenia' => date('Y-m-d H:i:s'),
							'grupa_id' => 1
						));
						//using flash method from Session
						//we flash a session message
						Session::flash('home','Zostałeś zarejestrowany!');//we want it to apper at homepage
						Redirect::to('index.php');  // we're defining the path we want to redirect to
							
						} catch(Exception $e) {//we're able to catch any problems
							die($e->getMessage());//we're killing the script
						}
				} else {//output errors
					$this->view('validatenotpassed', $validate->errors());
					return true;
				}
			}
		}
	$this->view('register');
	}
}
?>











