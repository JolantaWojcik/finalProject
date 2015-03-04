<?php
class Validate {
	private $_passed = false, //3 private properties; passed is false by default because we want to assume that it's not passed
			$_errors = array(),
			$_db = null; //so it's  nothing
			
	public function __construct() { //it's called when the validate class is instantiated 
		if($this->_db = DB::getInstance()) { // we set db to DB getInstance
		};
	}
	
	public function check($source, $items = array()) {
		//print_r($source); the main idea is to list thourgh the rules that we've defined and in each of them we want to list thought the rules  inside of them, check it against the source that we've provided and then add to the errors as we go
	
		foreach($items as $item => $rules) {//we loop through the items from the register class /login, haslo, itp./ and rules ar arrays in those items
			foreach($rules as $rule => $rule_value) { //loop through the set of rules; we've got nested foreach.
				$value = trim($source[$item]);	//we grab the value of each of these items; /value is source so it's get or post/. We trim this so that we don't end up with any white space.			
				$item = escape($item);						
				// now we want to check if it /value/ is required or not. If the value is missing, there's no point in validating anything else; if we don't enter username, there's no point checking whether it exists in the database, and chekcing minimum  and maximum values
				// firstly we check if it exists
				if($rule === 'required' && empty($value)) { // if we're defining that sth has to be required and is empty, then we've got a problem
					$this->addError("musisz wypełnić pole {$item}"); // we're saying that item is required
				} else if(!empty($value)) { // now we want to fill in the ability for the rules that we've created in REGISTER . If not empty value
					switch($rule) { // we switch the rules
						case 'min': // now we make case for each fo the rules that we've already defined.
							if(strlen($value) < $rule_value) { //We check if the string length fo the value is less than the rule value that we've defined
								$this->addError("{$item} musi mieć minimum {$rule_value} znaków."); // then we want to add error
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} musi mieć minimum {$rule_value} znaków.");
							}
						break;
						case 'matches': //we want to check if the value is not equal to the source rule value
							if($value != $source[$rule_value]) {  
								$this->addError("{$rule_value} musi być identyczne do {$item}");
							}
						break;
						case 'unique':  // we're using the database ?wrapper?, we're going to use get method
							if($check = $this->_db->get($rule_value, array($item, '=', $value))) { 
							}
							if($check->count()) { //if the value is positive, it means that the item name already existst in the database
								$this->addError("{$item} już istnieje");
							}
						break;
					}
				}
			}
		}
		if(empty($this->_errors)) { //we check if our errors array is empty or not
			$this->_passed = true; //if it's empty; we haven't stored any errors.
		}
	}

	private function addError($error) { //this method is  going to add error to the errors array
		$this->_errors[] = $error; 
	}
	
	public function errors() { // this method is going to return the list of errors that we have
		return $this->_errors;
	}
	
	public function passed() { // we're finding if it's passed or not
		return $this->_passed; // it's always going to be false, look at the line 3
	}
}



?>	
