<?php
require_once("{$CFG->libdir}/formslib.php");
require_once("$CFG->dirroot/user/profile/lib.php"); //Custom user profile fields
require_once ('settingslib.php'); //Custom block functions

//The class cancelcourse_form and its function are required to display the form.	
class cancelcourse_form extends moodleform{

	function definition(){
		$mform =& $this->_form;
		//display the headers
		$mform->addElement('html','<style>.cancelcourse_hide{display: none;}.cancelcourse_show{display: inline;}</style>');
		$mform->addElement('header','displayinfo', get_string('cancelclassfields', 'block_cancelcourse')); 
		
		//show custom email textbox if option is enabled
		if(get_config('cancelcourse','showcustomtext')){
		$mform->addElement('textarea', 'customtext', get_string('customtext', 'block_cancelcourse'), 'wrap="virtual" rows="6" cols="50"');
		$mform->addHelpButton('customtext', 'customtexthelp', 'block_cancelcourse');
		}
		
		//Hidden fields. Populated by information sent from view.php
		$mform->addElement('hidden', 'id');
		$mform->setType('id', PARAM_INT);
		$mform->addElement('hidden', 'blockid');
		$mform->setType('blockid', PARAM_INT);
		$mform->addElement('hidden', 'messagelang');
		$mform->setType('messagelang', PARAM_NOTAGS);
		$mform->addElement('hidden', 'profname');
		$mform->setType('profname', PARAM_NOTAGS);
		
		//Are you sure?
		$mform->addElement('html','<h1 style="color: red;">'.get_string('confirm','block_cancelcourse').'</h1>');
		
		//Add submit buttons, etc.
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('savebutton', 'block_cancelcourse'), array('onclick'=>'showText(\'cancelcourse_loadingimage\',\'id_submitbutton\',\'id_cancel\')','class'=>'cancelcourse_show'));
		$buttonarray[] = &$mform->createElement('cancel', 'cancel', get_string('cancelbutton', 'block_cancelcourse'));
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->closeHeaderBefore('buttonar');
		
		//insert the javascript for the loading image
		$mform->addElement('html', '<script type="text/javascript">
			function showText(show,hide1,hide2)
			{
				document.getElementById(show).className = "cancelcourse_show";
				document.getElementById(hide1).className = "cancelcourse_hide";
				document.getElementById(hide2).className = "cancelcourse_hide";
			}
			</script>
			<div style="clear:both;"></div>
			<div class="cancelcourse_hide" id="cancelcourse_loadingimage">
			<h4 style="display: block; border: 2px solid blue; background-color:#b2b2ff; padding: 5px;"><img src="loading.gif"/> ' . get_string('sending_message_please_wait', 'block_cancelcourse') . '</h4>
			</div>'
			); 
	}
}