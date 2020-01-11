<?php

// let cron jobs edit and delete message queue messages
function message_queue_permission_check($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	if ($entity instanceof MessageQueue) {
		return true;
	}

	return $returnvalue;
}

function message_queue_send_emails() {
	$end_time = time() + 240;

	$max_emails = elgg_get_plugin_setting('max_emails', 'message_queue');
	if (!$max_emails) {
		$max_emails = 200;
	}
	$emails_sent = 0;

	// start with current jobs (left over from previous cron run)
	$emails_sent = message_queue_send_message_type('sending', $emails_sent, $max_emails, $end_time);
	$message_limit = $max_emails - $emails_sent;

	// if still within quota and still time left, start new jobs
	if (($message_limit > 0) && ($end_time > time())) {
		message_queue_send_message_type('unsent', $emails_sent, $max_emails, $end_time);
	}
}
