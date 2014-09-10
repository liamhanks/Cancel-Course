<?php
require_once('../../config.php');
require_once('cancelcourse_form.php');
require_once ($CFG->dirroot.'/blocks/cancelcourse/settingslib.php'); //Custom block functions

global $DB, $OUTPUT, $PAGE, $COURSE, $CFG;
//Check for all required variables
$courseid = required_param('id', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
$messagelang = required_param('messagelang', PARAM_NOTAGS);
$profname = urldecode(required_param('profname', PARAM_NOTAGS));
//Next look for optional variables
//$id = optional_param('id', 0, PARAM_INT);

if(!$course = $DB->get_record('course', array('id' => $courseid))){
	print_error('invalidcourse', 'block_cancelcourse', $courseid);
}

require_login($course);
$PAGE->set_url('/blocks/cancelcourse/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('cancelthisclass', 'block_cancelcourse'));

$cancelcourse = new cancelcourse_form(); //The form object

//information to pass to the hidden fields in the form.
$toform['blockid'] = $blockid;
$toform['id'] = $courseid;
$toform['messagelang'] = $messagelang;
$toform['profname'] = $profname;
$cancelcourse->set_data($toform);

$context = get_context_instance(CONTEXT_COURSE, $courseid);

if(has_capability('block/cancelcourse:view',$context)){ //make sure the user has permission
	if($cancelcourse->is_cancelled()){ //Cancelled forms redirect to the course main page.
		$courseurl = new moodle_url('/course/view.php', array('id'=>$courseid));
		redirect($courseurl);
	}elseif($fromform = $cancelcourse->get_data()){ //Do the following when form is submitted
		echo $OUTPUT->header();
		$site = get_site();
		$formdata = get_object_vars($fromform); //turn the object into an array

/************************************  This is where the sending actually occurs!  ***************************************/
		
		//Set the subject line
		if(get_config('cancelcourse','subject'.$messagelang)){ //use custom language-specific subject, if provided
			$subject = get_config('cancelcourse','subject'.$messagelang);
		}else{ //if custom fields aren't configured, default to English.
			$subject = "Class Cancelled";
		}
		
		
		//Send text message emails to users who have their cell number in their profile
		if(get_config('cancelcourse', 'sendtext')){ //is option selected?
		$address_array = send_textmessages();
			if($address_array){
				if((require_once("../../lib/phpmailer/moodle_phpmailer.php")) && ($CFG->smtphosts) && (get_config('cancelcourse', 'providername'))){ //is everything configured?
					//setup the message body and shorten the strings as needed
					if(get_config('cancelcourse','includeshortname')){ //Course Code
						$shortname = short_string($COURSE->shortname,10);
					}
					if(get_config('cancelcourse','includefullname')){ //Course Title
						$fullname = ' ' . short_string($COURSE->fullname,69);
					}
					if(get_config('cancelcourse','includeprofname') && ($profname != 'none')){ //Professor Name
						$name = ' (' . short_string($profname,25) . ')';
					}
					$subjectcell = short_string(short_string($subject,130-strlen($shortname . $fullname . $name)),75);
					
					//Send the text messages
					//require_once("../../lib/phpmailer/class.phpmailer.php");
					$mail = new PHPMailer();
					$mail->IsSMTP();
					
						$smtpserv = preg_replace('[;.*]','',$CFG->smtphosts); //take only first host
						$smtpserv = explode(":",$smtpserv); //separate host and port
				
					$mail->Host		= $smtpserv[0];
					if(isset($smtpserv[1])){
						$mail->Port		= $smtpserv[1];
					}
					if($CFG->smtpsecure){
						$mail->SMTPSecure	= $CFG->smtpsecure;
					}
					if($CFG->smtpuser){
						$mail->Username	= $CFG->smtpuser;
						$mail->SMTPAuth	= true;
					}
					if($CFG->smtppass){
						$mail->Password = $CFG->smtppass;
					}
					foreach(array_unique($address_array) as $cellemail){
						$mail->AddBCC($cellemail);
						//echo $cellemail . '<br>';
					}
					if ($CFG->noreplyaddress){ //if noreply isn't specified, use moodle default.
						$mail->From 	= $CFG->noreplyaddress;
					}else{
						$mail->From		= 'noreply@' . get_host_from_url($CFG->wwwroot); 
					}
					
					$mail->FromName = "noreply";
					$mail->Subject 	= no_accents($subjectcell);
					
					
					$mail->Body 	= no_accents($shortname . $fullname . $name);
					$mail->WordWrap =75;
					$mail->CharSet = 'UTF-8';
					if($mail->Send()){
						echo '<div class="box generalbox" style="background-color: #73c376; font-weight: bold;"><p>' . get_string('textmessage_sent', 'block_cancelcourse') . '</p></div>';
						$text_success = true;
					}else{
						echo print_error('textmessage_notsent', 'block_cancelcourse' . $mail->ErrorInfo);
						$text_success = false;
					}
					$mail->SmtpClose();
				}else{ //error!
					echo print_error('textmessage_configerror','block_cancelcourse');
				}
			}else{
				$text_success = true; //There were no recipients to send to, set success at true (there was no technical failure!)
			}
		}else{
			$text_success = true; //if texting is NOT selected, set success as true.
		}
		
		//Send an email to each enrolled user, if option is selected
		if(get_config('cancelcourse', 'sendemail')){ //is option selected?
			if((require_once("../../lib/phpmailer/moodle_phpmailer.php")) && ($CFG->smtphosts)){ //is everything configured?
				//setup the message body
				if(get_config('cancelcourse','includeshortname')){
					$shortname = ' : ' . $COURSE->shortname;
				}
				if(get_config('cancelcourse','includefullname')){
					$fullname = ' ' . $COURSE->fullname;
				}
				if(get_config('cancelcourse','includeprofname') && ($profname != 'none')){
					$name = ' (' . $profname . ')';
				}
				
				//get the list of registered users' emails
				$emails = array_keys(get_enrolled_users($context,$withcapability = '', $groupid = 0, $userfields = 'u.email'));
				//add the list of admin emails from the global config, and remove duplicates
				$emails = array_unique(array_merge($emails,explode(',',get_config('cancelcourse','adminemails'))));
				if(isset($formdata['customtext'])){
					$customtext = $formdata['customtext'];
				}else{
					$customtext = '';
				}
				
				//Send the email
				$mail = new PHPMailer();
				$mail->IsSMTP();
				
					$smtpserv = preg_replace('[;.*]','',$CFG->smtphosts); //take only first host
					$smtpserv = explode(":",$smtpserv); //separate host and port
			
				$mail->Host		= $smtpserv[0];
				if(isset($smtpserv[1])){
					$mail->Port		= $smtpserv[1];
				}
				if($CFG->smtpsecure){
					$mail->SMTPSecure	= $CFG->smtpsecure;
				}
				if($CFG->smtpuser){
					$mail->Username	= $CFG->smtpuser;
					$mail->SMTPAuth	= true;
				}
				if($CFG->smtppass){
					$mail->Password = $CFG->smtppass;
				}
				foreach($emails as $email){
					$mail->AddBCC($email);
					//echo $email . '<br>';
				}
				if ($CFG->noreplyaddress){ //if noreply isn't specified, use moodle default.
					$mail->From 	= $CFG->noreplyaddress;
				}else{
					$mail->From		= 'noreply@' . get_host_from_url($CFG->wwwroot); 
				}
				
				$mail->FromName = "noreply";
				$mail->Subject 	= short_string($subject,75);
				$mail->Body 	= $subject . ' ' . get_string('today') . ' ' . date('Y-m-d') . ':' . $shortname . $fullname . $name . PHP_EOL . PHP_EOL . $customtext;
				$mail->WordWrap = 75;
				$mail->CharSet = 'UTF-8';
				
				if($mail->Send()){
					echo '<div class="box generalbox" style="background-color: #73c376; font-weight: bold;"><p>' . get_string('emailmessage_sent', 'block_cancelcourse') . '</p></div>';
					$email_success = true;
				}else{
					echo print_error('emailmessage_notsent', 'block_cancelcourse' . $mail->ErrorInfo);
					$email_success = false;
				}
				$mail->SmtpClose();
			}else{ //error!
				echo print_error('emailmessage_configerror','block_cancelcourse');
			}
		}else{
			$email_success = true; //if emailing is NOT selected, set success as true.
		}
		
		//Tweets the cancellation if all of the settings are configured
		if(get_config('cancelcourse','sendtweet')){ //is the tweeting option selected?
			if(get_config('cancelcourse','ckey') && get_config('cancelcourse','csecret') && get_config('cancelcourse','utoken') && get_config('cancelcourse','usecret')){
				//setup the message body and shorten the strings as needed
				if(get_config('cancelcourse','includeshortname')){
					$shortname = ' : ' . short_string($COURSE->shortname,10);
				}
				if(get_config('cancelcourse','includefullname')){
					$fullname = ' ' . short_string($COURSE->fullname,69);
				}
				if(get_config('cancelcourse','includeprofname') && ($profname != 'none')){
					$name = ' (' . short_string($profname,25) . ')';
				}
				$subjecttwitter = short_string(short_string($subject,130-strlen($shortname . $fullname . $name)),75);
				
				//send the tweet and report results
				if(send_tweet(get_config('cancelcourse','ckey'),get_config('cancelcourse','csecret'),get_config('cancelcourse','utoken'),get_config('cancelcourse','usecret'),$subjecttwitter . $shortname . $fullname . $name)){
					echo '<div class="box generalbox" style="background-color: #73c376; font-weight: bold;"><p>' . get_string('tweetsuccess','block_cancelcourse') . '</p></div>';
					$tweet_success = true;
				}else{
					$tweet_success = false;
					echo print_error('tweetfailed','block_cancelcourse'); //either the configuration is wrong, or the twitter API is returning an error.
				}
			}else{ //error!
				echo print_error('twittermessage_configerror','block_cancelcourse');
			}
		}else{
			$tweet_success = true; //if tweet is NOT selected, set the success as true.
		}
		
		if ((!get_config('cancelcourse','sendtweet')) && (!get_config('cancelcourse', 'sendemail')) && (!get_config('cancelcourse', 'sendtext'))){
			echo print_error('nosending_error','block_cancelcourse');
		}
		
		if($text_success && $email_success && $tweet_success){
			if(!cancelled_now($courseid)){
				echo print_error('dberror','block_cancelcourse');
			}else{
				$url = new moodle_url('/course/view.php', array('id' => $COURSE->id));
				echo html_writer::link($url, get_string('return_to_class', 'block_cancelcourse'));
			};
		}else{
			print_error('cancelerror','block_cancelcourse');
		}

		echo $OUTPUT->footer(); //add the footer
		//Uncomment next lines to redirect to the course main page.
		//$courseurl = new moodle_url('/course/view.php', array('id'=>$courseid));
		//redirect($courseurl);
	}else{ //form didn't validate or this is the first display
		$site = get_site();
		echo $OUTPUT->header();
		
		
		if(!already_cancelled($COURSE->id) || get_config('cancelcourse','multicancel')){
			$settingsnode = $PAGE->settingsnav->add(get_string('cancelcoursesettings', 'block_cancelcourse'));
			$editurl = new moodle_url('/blocks/cancelcourse/view.php', array('id' => $courseid, 'blockid' => $blockid));
			$editnode = $settingsnode->add(get_string('editpage', 'block_cancelcourse'), $editurl);
			$editnode->make_active();
			$cancelcourse->display(); //display the form.
			echo $OUTPUT->footer();
		}else{
			echo get_string('alreadycancelled','block_cancelcourse');
		}
		
	}
}else{ //Access denied! This user doesn't have persmission to do this (prevents direct URL access).
	echo $OUTPUT->header();
	$site = get_site();
	echo print_error('nopermissions');
	echo $OUTPUT->footer();
}
?>