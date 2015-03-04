<?php

class User {
	private $_db;
	private $_data;
	private $_sessionName;
	private $_cookieName;
	private $_isLoggedIn;
	//on construct we apply the static getInstance method of our DB class
	public function __construct($user = null) {
		$this->_db = DB::getInstance(); // we can now use the database
		
		$this->_sessionName = Config::get('session/session_name');  //we take a session and place it here for the application
		$this->_cookieName = Config::get('remember/cookie_name');   //hash
	//we want to detect whether the user is logged in or not
	// if we want to grab a specific user details, we're going to use the same user objects
		if(!$user) {
			if(Session::exists($this->_sessionName)) { //we want to check if the session actually exists, meaning if the user is logged in.
				$user = Session::get($this->_sessionName);  //$user zwraca id

					if($this->find($user)) { // we want to check if the user exists or not
						$this->_isLoggedIn = true;
					} else {
						// process Logout
					}
			}
			
		} else { //if the user has been defined
			$this->find($user); // it allow us to grab user's data of the user that isn't logged in
		}
	}
	
	public function update($fields = array(), $id = null) {
		
		if(!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		
		if(!$this->_db->update('uzytkownicy', $id, $fields)) {
			throw new Exception('Mamy problem z bazą danych');
		}
	}
	//ability to create a user:
	public function create($fields = array()) {
		if(!$this->_db->insert('uzytkownicy', $fields)) { // we want to apply it to the uzytkownicy table and fields
			//if it doesn't work out we want to:
			throw new Exception('Mamy pewien problem z utworzeniem Twojego konta!');
		}
	}
	//we want to also find the user by their id not just a username/login:
	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'login'; //if it's numeric we want the field to be id, otherwise login
			$data = $this->_db->get('uzytkownicy', array($field, '=', $user)); //data represents the data that we get back from the table. We get from the uzytkownicy table. And we're going to say where the field /id, or username/ is equal to user.
			//obiekt $this, czyli obiekt DB
			//we grab the data from the database:
			if($data->count()) {
			//we need to store the user data somewhere:
				$this->_data = $data->first();  //$this->_data will contain all of the users data; We take the first and only result in this case.
				return true; //it means that the user exists
			}
		}
		return false;
	} //ostatecznie to sprawia, że w $this->_data jest cały user
		//now we have to build the login method:
	public function login($login = null, $haslo = null, $remember = false) {
		
		if(!$login && !$haslo && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($login);  //user to true
		
		if($user) {
			if($this->data()->haslo === Hash::make($haslo, $this->data()->salt)) { //check the password //it basically means that the passwords match
				//we put the user id inside the partuclar session:
				Session::put($this->_sessionName, $this->data()->id); //we set a session; we store the user id
				
				if($remember) { // we want to see if remember is
					$hash = Hash::unique();

					$hashCheck = $this->_db->get('sesje', array('uzytkownicy_id', '=', $this->data()->id));  //POPSUTE
					//sprawdzam czy w sesjach jest ktos z id pauliny

					if(!$hashCheck->count()) {
						$hashCheck = $this->_db->insert('sesje', array(
							'uzytkownicy_id' => $this->data()->id,
							'hash' => $hash
						));
					} else {
						$hash = $hashCheck->first()->hash;
					}
					
					Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
				}
				return true; //successful login
			}
		}
	}
	return false;
	}
	
	public function exists() {
		return(!empty($this->_data)) ? true : false;
	}
	
	public function logout() {
		echo $this->data()->id;
		if($this->_db->delete('sesje', array('uzytkownicy_id', '=', $this->data()->id))) {
			echo "usunieto";
		}
	
		Session::delete($this->_sessionName); // we delete the session
		Cookie::delete($this->_cookieName);
	}
	
	public function data() {
		return $this->_data;
	}
	
	public function isLoggedIn() { //getter
		return $this->_isLoggedIn;
	}
	
}
