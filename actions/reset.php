<?php

$messages = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => MessageQueue::SUBTYPE,
	'metadata_name' => 'status',
	'metadata_value' => 'unsent',
	'limit' => false,
	'batch' => true,
	'batch_inc_offset' => false,
]);

foreach ($messages as $message) {
	$message->delete();
}

$messages = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => MessageQueue::SUBTYPE,
	'metadata_name' => 'status',
	'metadata_value' => 'sending',
	'limit' => false,
	'batch' => true,
	'batch_inc_offset' => false,
]);

foreach ($messages as $message) {
	$message->delete();
}

return elgg_ok_response('', elgg_echo('message_queue:reset:ok'), REFERER);
