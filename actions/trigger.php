<?php

$site = elgg_get_site_entity();

$messages = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => MessageQueue::SUBTYPE,
	'metadata_name' => 'status',
	'metadata_value' => $type,
	'limit' => false,
	'batch' => true,
	'batch_inc_offset' => false,
]);

foreach ($messages as $message) {

	if ($message->status != "locked") {
		$message->status = "locked";
	} else {
		break;
	}

	$users = elgg_get_entities_from_relationship([
		'type' => 'user',
		'relationship' => 'message_queue',
		'relationship_guid' => $message->guid,
		'inverse_relationship' => true,
		'limit' => false,
		'batch' => true,
		'batch_inc_offset' => false,
	]);

	$subject = $message->title;
	$body = $message->description;
	$message_id = $message->guid;

	foreach ($users as $to) {
		notify_user($to->guid, $site->guid, $subject, $body, [], ['email']);
		remove_entity_relationship($to->guid, 'message_queue', $message_id);
	}

	if ($message instanceof MessageQueue) {
		$message->delete();
	}
}

return elgg_ok_response('', elgg_echo('message_queue:trigger:ok'), REFERER);
