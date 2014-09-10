<?php
$capabilities = array(
	'block/cancelcourse:myaddinstance' => array(
		'captype' => 'write',
		'contextlevel' => CONTEXT_SYSTEM,
		'archetypes' => array(
			'user' => CAP_ALLOW
		),
		
		'clonepermissionsfrom' => 'moodle/my:manageblocks'
	),
	
	'block/cancelcourse:addinstance' => array(
		'riskbitmask' => RISK_SPAM | RISK_XSS,
		
		'captype' => 'write',
		'contextlevel' => CONTEXT_BLOCK,
		'archetypes' => array(
			'editingteacher' => CAP_ALLOW,
			'manager' => CAP_ALLOW,
		),
		
		'clonepermissionsfrom' => 'moodle/site:manageblock'
	),
	
	'block/cancelcourse:view' => array(
		'captype'      => 'read',
		'contextlevel' => CONTEXT_BLOCK,
		  'archetypes' => array(
			'guest'          => CAP_PREVENT,
			'student'        => CAP_PREVENT,
			'teacher'        => CAP_ALLOW,
			'editingteacher' => CAP_ALLOW,
			'coursecreator'  => CAP_ALLOW,
			'manager'        => CAP_ALLOW
		  )
		),
);

?>