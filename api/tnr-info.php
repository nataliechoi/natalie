<?php

require_once 'index.php';

$tnr_id = filter_input(INPUT_GET, 'id');

if (!is_null($tnr_id) && !empty($tnr_id)) {
	$query	 = $db->prepare('SELECT name, tel, client, target, duration FROM tnr WHERE id = ?');
	$query->execute(array($tnr_id));
	$info	 = $query->fetch(PDO::FETCH_ASSOC);
	exit(json_encode(array(
		'status'	 => 1,
		'message'	 => 'Success',
		'data'		 => $info
	)));
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'Bad Request'
)));
