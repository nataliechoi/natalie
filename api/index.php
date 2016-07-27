<?php
session_start();

$request = filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH');
if (empty($request) || strtolower($request) !== 'xmlhttprequest') {
	exit(json_encode(array(
		'status'	 => 0,
		'message'	 => 'Forbidden'
	)));
}

$conn	 = "mysql:host=localhost;dbname=natalie";
$db		 = new PDO($conn, 'natalie', 'Natalie1!');
$db->exec("SET NAMES 'utf8';");
