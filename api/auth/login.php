<?php

require_once '../index.php';

$username	 = filter_input(INPUT_POST, 'username');
$password	 = filter_input(INPUT_POST, 'password');

if (
	!is_null($username) && !empty($username) &&
	!is_null($password) && !empty($password)
) {
	$query	 = $db->prepare('SELECT id, first_name, last_name, email, oauth, token FROM user WHERE email = ? AND password = ?');
	$query->execute(array($username, $password));
	if (($user	 = $query->fetch(PDO::FETCH_ASSOC))) {
		$_SESSION['user'] = $user;
		exit(json_encode(array(
			'status'	 => 1,
			'message'	 => 'Success', 
			'data'		 => NULL
		)));
	}
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'Username or Password incorrect'
)));
