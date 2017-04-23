Message Queue plugin for Elgg 1.9 - 1.12 and Elgg 2.X
=====================================================

Latest Version: 1.9.2  
Released: 2017-04-23  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly 2015, (C) Kevin Jardine (Radagast Solutions) 2009


Description
-----------

The Message Queue plugin has been developed by Kevin Jardine originally. It's a utility plugin that supplies message queuing services to other plugins. This enables emails to be sent via cron jobs, i.e. sending them at a defined later time. For example the Event Calendar plugin makes use of the Message Queue plugin for (optionally) sending of reminders messages shortly before the event is to start.

For the Message Queue plugin to work you need to have the Elgg fiveminute cronjob correctly configured.

Installation
------------

1. If you have installed a previous version of the Message Queue plugin plugin disable the plugin in the admin section of your site and then remove the message_queue folder from the mod directory of your Elgg installation,
2. Copy the message_queue folder into the mod directory of your Elgg installation,
3. Enable the Message Queue plugin plugin in the admin section of your site and adjust the plugin settings if desired.
