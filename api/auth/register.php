<?php

require_once '../index.php';

$first_name	 = filter_input(INPUT_POST, 'first_name');
$last_name	 = filter_input(INPUT_POST, 'last_name');
$email		 = filter_input(INPUT_POST, 'email');
$password	 = filter_input(INPUT_POST, 'password');
$password2	 = filter_input(INPUT_POST, 'password2');

if (
	!is_null($first_name) && !empty($first_name) &&
	!is_null($last_name) && !empty($last_name) &&
	!is_null($email) && !empty($email) &&
	!is_null($password) && !empty($password) &&
	!is_null($password2) && !empty($password2)
) {
	if ($password === $password2) {
		$query = $db->prepare('SELECT * FROM user WHERE email = ?');
		$query->execute(array($email));
		if($query->rowCount() === 0) {
			$query = $db->prepare('INSERT INTO user (first_name, last_name, email, password, create_time) VALUE (?, ?, ?, ?, ?)');
			$query->execute(array($first_name, $last_name, $email, $password, time()));

			exit(json_encode(array(
				'status'	 => 1,
				'message'	 => 'Congratulation! You can login now', 
				'data'		 => NULL
			)));
		} else {
			exit(json_encode(array(
				'status'	 => 0,
				'message'	 => 'Email has been registered'
			)));
		}
	} else {
		exit(json_encode(array(
			'status'	 => 0,
			'message'	 => 'Confirm Password is incorrect'
		)));
	}
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'One or more fields are invalid'
)));
