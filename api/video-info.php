<?php

require_once 'index.php';

$video_id = filter_input(INPUT_GET, 'id');

if ( !is_null($video_id) && !empty($video_id) ) {
	$query	 = $db->prepare('SELECT id, name, code FROM video WHERE id = ?');
	$query->execute(array($video_id));
	$info	 = $query->fetch(PDO::FETCH_ASSOC);

	$query	 = $db->prepare('SELECT CONCAT(first_name, " ", last_name) as name, content, FROM_UNIXTIME(video_message.create_time, "%Y-%m-%d %H:%i:%s") as time FROM user, video_message WHERE video_message.user_id = user.id AND video_message.video_id = ? ORDER BY video_message.create_time DESC');
	$query->execute(array($video_id));
	$message = $query->fetchAll(PDO::FETCH_ASSOC);

	exit(json_encode(array(
		'status'	 => 1,
		'message'	 => 'Success',
		'data'		 => array(
			'info'		 => $info,
			'message'	 => $message
		)
	)));
}

exit(json_encode(array(
	'status'	 => 0,
	'message'	 => 'Bad Request'
)));
