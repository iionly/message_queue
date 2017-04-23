<?php

function message_queue_create_message($subject, $body) {
	$message = new ElggObject();
	$message->subtype = "message_queue_message";
	$message->access_id = ACCESS_PRIVATE;
	$message->owner_guid = elgg_get_logged_in_user_guid();
	$message->container_guid = $message->owner_guid;
	$message->title = $subject;
	$message->description = $body;
	$message->status = 'creating';
	if ($message->save()) {
		return $message;
	} else {
		return false;
	}
}

function message_queue_add($message_id, $user_id) {
	add_entity_relationship($user_id, 'message_queue', $message_id);
}

function message_queue_set_for_sending($message_id) {
	$message = get_entity($message_id);
	$message->status = 'unsent';
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
	if (($message_limit > 0) && ($end_time < time())) {
		message_queue_send_message_type('unsent', $emails_sent, $max_emails, $end_time);
	}
}

function message_queue_send_message_type($type, $emails_sent, $max_emails, $end_time) {
	$site = elgg_get_site_entity();
	$options = array(
		'type' => 'object',
		'subtype' => 'message_queue_message',
		'metadata_name' => 'status',
		'metadata_value' => $type,
		'limit' => $max_emails,
	);

	$ia = elgg_set_ignore_access(true);

	$messages = new ElggBatch('elgg_get_entities_from_metadata', array($options));
	$messages->setIncrementOffset(false);
	foreach ($messages as $message) {
		$message_limit = $max_emails - $emails_sent;
		if (($message_limit <= 0) || ($end_time > time())) {
			break;
		}

		// lock the message to avoid the small chance that another cron job might try sending it
		$message->status = "locked";
		$options = array(
			'type' => 'user',
			'relationship' => 'message_queue',
			'relationship_guid' => $message->getGUID(),
			'inverse_relationship' => true,
			'limit' => $message_limit,
		);
		$users = new ElggBatch('elgg_get_entities_from_relationship', array($options));

		if ($users) {
			$subject = $message->title;
			$body = $message->description;
			$message_id = $message->getGUID();
			foreach ($users as $to) {
				notify_user($to->getGUID(), $site->getGUID(), $subject, $body, array(), array('email'));
				remove_entity_relationship($to->guid, 'message_queue', $message_id);
			}
			$user_count = count($users);
			$emails_sent += $user_count;
			if ($user_count < $message_limit) {
				// all done
				$message->delete();
			} else {
				// there might be more messages to send
				// so set flag and check next time the cron job runs
				$message->status = "sending";
			}
		} else {
			// nothing left to do
			$message->delete();
		}
	}

	elgg_set_ignore_access($ia);

	return $emails_sent;
}
