<?php

require_once '../index.php';

if ( !isset($_SESSION['user']) ) {
	exit(json_encode(array(
		'status'	 => 0,
		'message'	 => 'You must login to access this area'
	)));
}

if ( !is_null(filter_input(INPUT_GET, 'create')) ) {
	$video_id	 = filter_input(INPUT_POST, 'video_id');
	$content	 = filter_input(INPUT_POST, 'comment');
	$query		 = $db->prepare('INSERT INTO video_message (video_id, user_id, content, create_time) VALUES (?, ?, ?, ?)');
	$query->execute(array($video_id, $_SESSION['user']['id'], $content, time()));
	exit(json_encode(array(
		'status'	 => 1,
		'message'	 => 'Success',
		'data'		 => NULL
	)));
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'Bad Request'
)));
