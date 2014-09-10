<?php
class block_cancelcourse_edit_form extends block_edit_form{
	
	protected function specific_definition($mform){
	
		$mform->addElement('header','configheader',get_string('messagesettings', 'block_cancelcourse'));
		
		
		$lang = array_merge(array('' => get_string('none', 'block_cancelcourse')),get_string_manager()->get_list_of_translations());
		//var_dump($lang);
		
		$mform->addElement('select', 'config_language', get_string('config_language', 'block_cancelcourse'), $lang );
		$mform->addElement('text', 'config_profname', get_string('config_profname', 'block_cancelcourse'));
		$mform->setType('config_profname', PARAM_NOTAGS);
	}
}

?>