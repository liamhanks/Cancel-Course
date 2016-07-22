<?php
require_once ($CFG->dirroot.'/blocks/cancelcourse/settingslib.php'); //Custom block functions
class block_cancelcourse extends block_base{
	public function init() {
		$this->title = get_string('cancelcourse', 'block_cancelcourse'); //initialize the block. Leave this alone.
	}
	
	public function instance_allow_multiple() { //False=only one instance of the block is possible per course.
		return false;
}
	
	public function get_content(){
		global $COURSE, $CFG; //load the global parameters
		$context = context_course::instance($COURSE->id); //set the context
		//var_dump(already_cancelled($COURSE->id));
	
		if(has_capability('block/cancelcourse:view',$context)){ //does the user have the block:view capability?
			if($this->content !== null){ //does the block have content?
				return $this->content; //display the block
			}
			
			$this->content			= new stdClass;
			
			//use the block-setting specified language. If it's not set, use the current user's display language for the message.
			if ((!isset($this->config->language)) || (!$this->config->language)){
				$messagelang = current_language();
			}else{
				$messagelang = $this->config->language;
			}
			//set the professor's name from the block configuration. If it's not set, use a default.
			if ((!isset($this->config->profname)) || (!$this->config->profname)){
				$profname = 'none';
			}else{
				$profname = urlencode($this->config->profname);
			}
			
			if(!already_cancelled($COURSE->id) || get_config('cancelcourse','multicancel')){
			//add all the parameters to the link so that everything we need makes it to the next step.
				$url = new moodle_url('/blocks/cancelcourse/view.php', array('id' => $COURSE->id, 'blockid' => $this->instance->id, 'messagelang' => $messagelang, 'profname' => $profname));
				$this->content->footer = html_writer::link($url, get_string('cancelclass', 'block_cancelcourse'));
			}else{
				$this->content->footer = get_string('alreadycancelled','block_cancelcourse');
			}
			return $this->content;
		}
	}
	public function applicable_formats() {
		return array('course-view' => true); //only available in the Course view
	}

	function has_config() {return true;} //2.4 compatibility: this block has global configuration.
	
	function _self_test() { //Moodle 3.x compatibility
		return true;
	}
}

	


?>
