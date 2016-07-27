<?php

require_once '../index.php';

$auth	 = filter_input(INPUT_POST, 'auth');
$data	 = filter_input(INPUT_POST, 'data', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

if (
		!is_null($auth) && !empty($auth) &&
		!is_null($data) && !empty($data)
 ) {
	$query	 = $db->prepare('SELECT * FROM user WHERE token = ?');
	$query->execute(array($data['id']));
	if ( ($user	 = $query->fetch(PDO::FETCH_ASSOC) ) ) {
		unset($user['password'], $user['create_time']);
		$_SESSION['user'] = $user;
	} else {
		$query				 = $db->prepare('INSERT INTO user (first_name, last_name, oauth, token, create_time) VALUE (?, ?, ?, ?, ?)');
		$query->execute(array($data['first_name'], $data['last_name'], $auth, $data['id'], time()));
		$_SESSION['user']	 = array(
			'id'		 => $db->lastInsertId(),
			'first_name' => $data['first_name'],
			'last_name'	 => $data['last_name'],
			'email'		 => NULL,
			'oauth'		 => $auth,
			'token'		 => $data['id']
		);
	}
	$_SESSION['user']['avatar'] = $auth === 'google' ? str_replace('?sz=50', '?sz=140', $data['picture']) : "{$data['picture']}?width=140";
	exit(json_encode(array(
		'status'	 => 1,
		'message'	 => 'Success',
		'data'		 => NULL
	)));
} else {
	exit(json_encode(array(
		'status'	 => 0,
		'message'	 => 'No Auth'
	)));
}