<?php

$entity = elgg_extract('entity', $vars);

$messages_unsent_count = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => MessageQueue::SUBTYPE,
	'metadata_name' => 'status',
	'metadata_value' => 'unsent',
	'count' => true,
]);

$messages_sending_count = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => MessageQueue::SUBTYPE,
	'metadata_name' => 'status',
	'metadata_value' => 'sending',
	'count' => true,
]);

echo elgg_view('output/longtext', [
	'value' => elgg_echo('message_queue:settings:unsent_emails', [$messages_unsent_count, $messages_sending_count]),
]);

echo elgg_format_element('div', ['class' => 'mvl'], elgg_view('output/url', [
	'href' => 'action/message_queue/trigger',
	'text' => elgg_echo('message_queue:trigger'),
	'is_action' => true,
	'is_trusted' => true,
	'confirm' => elgg_echo('message_queue:trigger:confirm'),
	'class' => 'elgg-button elgg-button-action',
]));

echo elgg_format_element('div', ['class' => 'mvl'], elgg_view('output/url', [
	'href' => 'action/message_queue/reset',
	'text' => elgg_echo('message_queue:reset'),
	'is_action' => true,
	'is_trusted' => true,
	'confirm' => elgg_echo('message_queue:reset:confirm'),
	'class' => 'elgg-button elgg-button-action',
]));

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('message_queue:settings:max_emails:title'),
	'name' => 'params[max_emails]',
	'value' => (int) $entity->max_emails ? : 200,
	'min' => 1,
	'step' => 1,
]);
