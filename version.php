<?php
/*********************************************************************************************
This plugin was designed by Liam Hanks (liam@liamhanks.com).

FUTURE FEATURES 
	-ability to show course status (active/cancelled) to students
	
CHANGELOG
	2014091015
		Updated get_context_instance to context_course::instance(). Added a local copy of PHPMailer to avoid future moodle update problems. Updated all moodle_PHPMailer.php requires to /PHPMailer/PHPMailerAutoload.php.
	2014090812
		Updated class.PHPMailer.php to moodle_PHPMailer.php to account for new version of PHPMailer. This does not allow for backward-compatibility.
	2013092311
		Added "today [date]" to email body text to make the cancellation date clear in the message.
	2013092310
		Corrected bug to enable sending of messages if no students have their cell phone added to their profile. Was previously causing a fatal error.
	2013081219
		Added global config option to enable or disable cancelling more than once per day.


*********************************************************************************************/

$plugin->version = 2014091015; //YYYYMMDDHH
$plugin->requires = 2013111804; //YYYYMMDDHH