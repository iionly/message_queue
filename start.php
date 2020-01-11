<?php

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');

elgg_register_event_handler('init', 'system', 'message_queue_init');

function message_queue_init() {
	// This library is no longer used and remains only for compatibility reasons for now.
	// The content of the library has been moved to functions.php and hooks.php.
	// The library model.php will get removed in version 3.0.0 (for Elgg 3.x)
	elgg_register_library('elgg:message_queue', dirname(__FILE__) . '/models/model.php');

	// Plugin hooks
	elgg_register_plugin_hook_handler('cron', 'fiveminute', 'message_queue_send_emails');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'message_queue_permission_check');
	
	// Register actions
	elgg_register_action('message_queue/trigger', dirname(__FILE__) . '/actions/trigger.php', 'admin');
	elgg_register_action('message_queue/reset', dirname(__FILE__) . '/actions/reset.php', 'admin');
}
