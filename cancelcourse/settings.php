<?php
defined('MOODLE_INTERNAL') || die;
require_once ($CFG->dirroot.'/blocks/cancelcourse/settingslib.php'); //Custom block functions

//Show the heading and description
$settings->add(new admin_setting_heading(
	'headerconfig',
	get_string('headerconfig', 'block_cancelcourse'),
	get_config_description()
	));

//Send texts?
$settings->add(new admin_setting_configcheckbox('cancelcourse/sendtext', get_string('sendtext', 'block_cancelcourse'), get_string('sendtextdesc', 'block_cancelcourse'),0));
//Shortname of the Providers custom user field
$settings->add(new admin_setting_configtext('cancelcourse/providername', get_string('providername', 'block_cancelcourse'), get_string('providerdesc', 'block_cancelcourse'),'', PARAM_ALPHANUM));
//Show config field for each provider					   
$providers = get_providers();
if(($providers[0] !== "") && get_config('cancelcourse', 'sendtext')){
	foreach ($providers as $provider){
		$settings->add(new admin_setting_configtext(providers_email($provider), $provider, get_string('provideremail', 'block_cancelcourse'),'',PARAM_TEXT));
		}
}
//Send emails?
$settings->add(new admin_setting_configcheckbox('cancelcourse/sendemail', get_string('sendemail', 'block_cancelcourse'), get_string('sendemaildesc', 'block_cancelcourse'),0));

//Subject line for messages?
foreach(get_string_manager()->get_list_of_translations() as $subjectlang => $key){
	$settings->add(new admin_setting_configtext('cancelcourse/subject'.$subjectlang, $key, get_string('subjectline', 'block_cancelcourse'),'Class Cancelled', PARAM_RAW));
}

//Tweet?
$settings->add(new admin_setting_configcheckbox('cancelcourse/sendtweet', get_string('sendtweet', 'block_cancelcourse'), get_string('sendtweetdesc', 'block_cancelcourse'),0));

//Twitter API keys
$settings->add(new admin_setting_configtext('cancelcourse/ckey', get_string('ckey', 'block_cancelcourse'), get_string('ckeydesc', 'block_cancelcourse'),'', PARAM_RAW));
$settings->add(new admin_setting_configtext('cancelcourse/csecret', get_string('csecret', 'block_cancelcourse'), get_string('csecretdesc', 'block_cancelcourse'),'', PARAM_RAW));
$settings->add(new admin_setting_configtext('cancelcourse/utoken', get_string('utoken', 'block_cancelcourse'), get_string('utokendesc', 'block_cancelcourse'),'', PARAM_RAW));
$settings->add(new admin_setting_configtext('cancelcourse/usecret', get_string('usecret', 'block_cancelcourse'), get_string('usecretdesc', 'block_cancelcourse'),'', PARAM_RAW));

//Include course short name?
$settings->add(new admin_setting_configcheckbox('cancelcourse/includeshortname', get_string('includeshortname', 'block_cancelcourse'), get_string('includeshortnamedesc', 'block_cancelcourse'),0)); 
//Include course full name?
$settings->add(new admin_setting_configcheckbox('cancelcourse/includefullname', get_string('includefullname', 'block_cancelcourse'), get_string('includefullnamedesc', 'block_cancelcourse'),0)); 
//Include course ID number?
$settings->add(new admin_setting_configcheckbox('cancelcourse/includeprofname', get_string('includeprofname', 'block_cancelcourse'), get_string('includeprofnamedesc', 'block_cancelcourse'),0)); 

//Allow course to be cancelled more than once per 24 hours?
$settings->add(new admin_setting_configcheckbox('cancelcourse/multicancel', get_string('multicancel', 'block_cancelcourse'), get_string('multicanceldesc', 'block_cancelcourse'),0)); 

//Allow custom email text?
$settings->add(new admin_setting_configcheckbox('cancelcourse/showcustomtext', get_string('showcustomtext', 'block_cancelcourse'), get_string('showcustomtextdesc', 'block_cancelcourse'),0)); 

//Comma delimited list of emails addresses to always be notified of course cancellations.
$settings->add(new admin_setting_configtextarea('cancelcourse/adminemails', get_string('adminemails', 'block_cancelcourse'),
                       get_string('adminemailsdesc', 'block_cancelcourse'),'', PARAM_RAW));
?>