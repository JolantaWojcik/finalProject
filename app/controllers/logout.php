<?php
require_once '../app/init.php';

$user = new User(); // we create a new user object to make use of the functionality inside of our user class
$user->logout(); // we logout

Redirect::to('index.php');
