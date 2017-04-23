<?php

$message_queue_max_emails = elgg_get_plugin_setting('max_emails', 'message_queue');
if (!$message_queue_max_emails) {
	$message_queue_max_emails = 200;
}

$messages_count = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'message_queue_message',
	'metadata_name' => 'status',
	'metadata_value' => 'unsent',
	'count' => true,
));

$body = elgg_echo('message_queue:settings:unsent_emails', array($messages_count));
$body .= '<br /><br />';
$body .= elgg_echo('message_queue:settings:max_emails:title');
$body .= '<br />';
$body .= elgg_view('input/text', array('name' => 'params[max_emails]', 'value' => $message_queue_max_emails));

$body .= '<br />';

echo $body;
