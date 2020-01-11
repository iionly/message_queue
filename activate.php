<?php
/**
 * Message Queue plugin
 *
 */

// Register the MessageQueue class for the object/message_queue_message subtype
if (get_subtype_id('object', MessageQueue::SUBTYPE)) {
	update_subtype('object', MessageQueue::SUBTYPE, 'MessageQueue');
} else {
	add_subtype('object', MessageQueue::SUBTYPE, 'MessageQueue');
}
