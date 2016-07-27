<?php

require_once '../index.php';

if ( !isset($_SESSION['user']) ) {
	exit(json_encode(array(
		'status'	 => 0,
		'message'	 => 'You must login to access this area'
	)));
}

if ( !is_null(filter_input(INPUT_GET, 'update')) ) {
	if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'PUT') {
		$data = array();
		parse_str(file_get_contents("php://input"), $data);
		if(
			!is_null($data) && !empty($data) && 
			isset($data['last_name']) && isset($data['first_name'])
		) {
			$query = $db->prepare('UPDATE user SET last_name = ?, first_name = ? WHERE id = ?');
			$query->execute(array($data['last_name'], $data['first_name'], $_SESSION['user']['id']));
			$_SESSION['user']['last_name'] = $data['last_name'];
			$_SESSION['user']['first_name'] = $data['first_name'];
			exit(json_encode(array(
				'status'	 => 1,
				'message'	 => 'Success',
				'data'		 => NULL
			)));
		}
	}
} else if ( !is_null(filter_input(INPUT_GET, 'changepw')) ) {
	if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'PUT') {
		$data = array();
		parse_str(file_get_contents("php://input"), $data);
		if(
			!is_null($data) && !empty($data) && 
			isset($data['old_password']) && isset($data['new_password']) && isset($data['confirm_password'])
		) {
			if ($data['new_password'] === $data['confirm_password']) {
				
				$query = $db->prepare('SELECT * FROM user where id = ? AND password = ?');
				$query->execute(array($_SESSION['user']['id'], $data['old_password']));
				if ( $query->rowCount() === 1 ) {
					$query = $db->prepare('UPDATE user SET password = ? WHERE id = ?');
					$query->execute(array($data['new_password'], $_SESSION['user']['id']));
					unset($_SESSION['user']);
					exit(json_encode(array(
						'status'	 => 1,
						'message'	 => 'Success',
						'data'		 => NULL
					)));
				} else {
					exit(json_encode(array(
						'status'	 => 0,
						'message'	 => 'Current Password is incorrect'
					)));
				}
				
			} else {
				exit(json_encode(array(
					'status'	 => 0,
					'message'	 => 'Confirm Password is incorrect'
				)));
			}
		}
	}
} else {
	$query = $db->prepare('SELECT first_name, last_name, email, oauth FROM user WHERE id = ?');
	$query->execute(array($_SESSION['user']['id']));
	exit(json_encode(array(
		'status'	 => 1,
		'message'	 => 'Success',
		'data'		 => $query->fetch(PDO::FETCH_ASSOC)
	)));
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'Bad Request'
)));
