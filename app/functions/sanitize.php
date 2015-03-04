<?php
function escape($string) {//we want to pass a string in
	return htmlentities($string, ENT_QUOTES, 'UTF-8');// we retrun a result of html entities function here. 
	//We're going to escape the string that we pass in, but its not quite enough as secure as it should be.
	// We define the ENT_QOUTES options which is basically going to encode/convert single and double quotes.
	// And the last is defining the character encodingfor this and this just makes a lot more secure in case we're dealing 
	//with encoding of a different type: so we choose UTF-8 here.
	// We include this class in init class
}
