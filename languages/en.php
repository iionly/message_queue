<?php

return [
	'message_queue:settings:unsent_emails' => "There are currently %s messages in the queue that were not yet processed. Additionally, there are %s messages where the processing has started but not yet finished. If the number of unsent messages piles up regularly, you likely have to increase the maximum number of messages to be sent per cron job run. If the messages in the queue are not processed at all, the fiveminute cronjob might not be configured correctly on your server. As additional options, you can either trigger the sending of queued messages independently of the fiveminute cronjob or you can delete all queued messages by clicking on the corresponding button below.",
	'message_queue:settings:max_emails:title' => "Maximum messages sent per cron job run",
	'message_queue:trigger' => "Trigger sending all qeued messages",
	'message_queue:trigger:confirm' => "Do you really want to trigger the sending of all unprocessed queued messages now?",
	'message_queue:reset' => "Empty message queue",
	'message_queue:reset:confirm' => "Do you really want to irrevocably delete all unprocessed messaged from the queue?",
	'message_queue:reset:ok' => "The queue was reset is now empty.",
	'message_queue:trigger:ok' => "Queue processed successfully.",
];