<?php

return [
	'message_queue:settings:unsent_emails' => "Derzeit sind %s Nachrichten in der Queue, die noch nicht verarbeitet wurden. Zusätzlich sind %s Nachrichten in der Queue, deren Bearbeitung begonnen aber noch nicht abgeschlossen wurde. Falls die Anzahl der noch nicht versendeten Nachrichten laufend größer wird, mußt Du wahrscheinlich die maximale Anzahl der pro Cron-Interval zu versendenden Nachrichten vergrößern. Falls die Nachrichten der Queue überhaupt nicht verarbeitet werden, ist wahrscheinlich der fiveminute-Cronjob auf Deinem Server nicht korrekt eingerichtet. Als weitere Möchlichkeiten kannst Du über die im folgenden angeboteten Optionen entweder die sofortige Verarbeitung der Queue starten (unabhängig vom fiveminute-Cronjob) oder Du kannst die Queue zurücksetzen und alle unversendeten Nachrichten löschen.",
	'message_queue:settings:max_emails:title' => "Maximale Anzahl der pro Cron-Interval zu versendenden Nachrichten",
	'message_queue:trigger' => "Queue jetzt abarbeiten",
	'message_queue:trigger:confirm' => "Möchtest Du wirklich jetzt die Verarbeitung aller unversendeter Nachrichten aus der Queue durchführen?",
	'message_queue:reset' => "Queue zurücksetzen",
	'message_queue:reset:confirm' => "Möchtest Du wirklich alle nicht verarbeiteten Nachrichten aus der Queue unwiderruflich löschen?",
	'message_queue:reset:ok' => "Die Queue wurde zurückgesetzt und ist nun leer.",
	'message_queue:trigger:ok' => "Die Queue wurde abgearbeitet und die Nachrichten versandt.",
];