<?php

require_once 'index.php';

$drug_id = filter_input(INPUT_GET, 'id');

if (!is_null($drug_id) && !empty($drug_id)) {
	$query	 = $db->prepare('SELECT name, content, pic FROM drug WHERE id = ?');
	$query->execute(array($drug_id));
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
