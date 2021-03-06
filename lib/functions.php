<?php

function message_queue_create_message($subject, $body) {
	$message = new MessageQueue();
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

function message_queue_send_message_type($type, $emails_sent, $max_emails, $end_time) {
	$site = elgg_get_site_entity();

	$ia = elgg_set_ignore_access(true);

	$messages = elgg_get_entities_from_metadata([
		'type' => 'object',
		'subtype' => MessageQueue::SUBTYPE,
		'metadata_name' => 'status',
		'metadata_value' => $type,
		'limit' => $max_emails,
		'batch' => true,
		'batch_inc_offset' => false,
	]);

	foreach ($messages as $message) {
		$message_limit = $max_emails - $emails_sent;
		if (($message_limit <= 0) || ($end_time <= time())) {
			break;
		}

		// lock the message to avoid the small chance that another cron job might try sending it
		$message->status = "locked";

		$users = elgg_get_entities_from_relationship([
			'type' => 'user',
			'relationship' => 'message_queue',
			'relationship_guid' => $message->guid,
			'inverse_relationship' => true,
			'limit' => $message_limit,
		]);

		if ($users) {
			$subject = $message->title;
			$body = $message->description;
			$message_id = $message->guid;
			$user_count = 0;
			foreach ($users as $to) {
				notify_user($to->guid, $site->guid, $subject, $body, [], ['email']);
				remove_entity_relationship($to->guid, 'message_queue', $message_id);
				$user_count++;
			}
			$emails_sent += $user_count;
			if ($user_count < $message_limit) {
				// all done
				if ($message instanceof MessageQueue) {
					$message->delete();
				}
			} else {
				// there might be more messages to send
				// so set flag and check next time the cron job runs
				$message->status = "sending";
			}
		} else {
			// nothing left to do
			if ($message instanceof MessageQueue) {
				$message->delete();
			}
		}
	}

	elgg_set_ignore_access($ia);

	return $emails_sent;
}
