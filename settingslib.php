<?php
//function to get the previous cancel date for the course.
function already_cancelled($classid){
	$date = date('Ymd');
	// table name = mdl_block_cancelcourse 
	global $DB;
	$sql = "SELECT `canceldate` FROM mdl_block_cancelcourse WHERE `classid` = $classid ORDER BY `canceldate` DESC LIMIT 0,1"; //get the most recent cancellation date from the database.
	$result = current($DB->get_records_sql($sql));
	$canceldate = $result->canceldate;
	if($canceldate < $date){
		return false; //Class has NOT been cancelled TODAY
	}else{
		return true; //Class HAS already been cancelled TODAY
	}
}

function cancelled_now($classid){
		$date = date('Ymd'); //the current date
		global $DB;
		
		//Set up the SQL 'INSERT'
		$record = new object();
			$record->id = NULL;
			$record->classid = (string)$classid;
			$record->canceldate = $date;
		//var_dump($record);
		if($DB->insert_record('block_cancelcourse',$record)){
			return true; //insert was a success.
		}else{
			return false; //insert failed.
		}
}

//Gets the list of providers configured in the custom user field for this purpose.
function get_providers(){
	global $DB;
	$providerSN = get_config('cancelcourse', 'providername'); //get the custom user field shortname
	$sql = "SELECT param1 FROM mdl_user_info_field WHERE shortname='$providerSN'"; //find the values from the database
	$result = current($DB->get_records_sql($sql));
	if($result)
		$result = explode("\n",$result->param1); //put the values into an array
	return $result;
}

//Sets the unique field names for the provider's email address fields.
function providers_email($providername){
	$prov_sett = 'cancelcourse/';
	if($providername){
	$prov_sett .= preg_replace('/\s+/','',$providername); //remove space, and add the entry to the setting name.
	}	else{
	$prov_sett .= 'noprovidername'; //default to this if no valid custom user field shortname (this shouldn't actually be possible, but you never know).
	}
	return $prov_sett;
}

//Sets the global settings description depending on current configuration (ie, show an error if needed)
function get_config_description(){
	global $CFG;
	$configdesc = '';
	$looksgood = '';
	if((get_config('cancelcourse', 'sendemail') || get_config('cancelcourse', 'sendtext')) && (!$CFG->smtphosts)){
		$configdesc .= '<div class="box errorbox"><p>' . get_string('emailconfigerror','block_cancelcourse') . '</p></div>';
	}
	if(get_config('cancelcourse', 'sendtext') && (get_providers(/*REMOVED result 2013071011*/)[0] === "")){ //if sending a text is selected, but no providers are given
		$configdesc .= '<div class="box errorbox"><p>' . get_string('novalidprovider','block_cancelcourse') . '</p></div>';
	}
	if(get_config('cancelcourse','sendtweet') && (!get_config('cancelcourse','ckey') || !get_config('cancelcourse','csecret') || !get_config('cancelcourse','utoken') || !get_config('cancelcourse','usecret'))){ //if tweeting is selected, but one (or more) required settings are missing.
		$configdesc .= '<div class="box errorbox"><p>' . get_string('tweetconfigerror','block_cancelcourse') . '</p></div>';
	}
	if ((get_config('cancelcourse', 'sendemail') || get_config('cancelcourse', 'sendtext') || get_config('cancelcourse','sendtweet')) && ($configdesc === '')){
		$looksgood = '<br><div class="box generalbox" style="background-color: #73c376; font-weight: bold;"><p>' . get_string('looksgood','block_cancelcourse') . '</p></div>';
	}
	if ($configdesc === ''){
		$configdesc = get_string('cancelcoursedescription', 'block_cancelcourse');
	}
	return $configdesc . $looksgood;
}

//Make shortened strings
function short_string($string,$length){ //Shortens any $string to the $length, minus 3, and adds an elipsis.
	if(strlen($string) > $length){
		$length = $length-3;
		$string = substr($string,0,$length) . "...";
	}
	return $string;
}

//Set up the text messaging list, if configured to do so.
//returns an array of addresses, format: [10-digit phone number]@[provider-suffix]
function send_textmessages(){
		if(get_config('cancelcourse', 'providername') && get_config('cancelcourse', 'sendtext')){ 
			global $COURSE, $CFG; //load the global parameters
			$context = context_course::instance($COURSE->id);
			
			//gets the user ID
			$userids = get_enrolled_users($context,$withcapability = '', $groupid = 0, $userfields = 'u.*');
			
			$addresses = array();	
			foreach($userids as $userid){ //Check each enrolled user for a phone number, and sends the text message to these users.
				//var_dump(profile_user_record($userid));
				if($userid->phone2){ //only procede if the user has filled in the cell phone number field in their profile.
					$providerSN = get_config('cancelcourse', 'providername'); //get the custom user field shortname
					$user_prov = (profile_user_record($userid->id)->$providerSN); //get the user's cell provider from their profile, if they specified one.
					//var_dump($userid->email); //for development only
					$prov_email = get_config('cancelcourse', preg_replace('/\s+/','',$user_prov)); //figure out the provider's email suffix.
					if($prov_email){ //a cell provider was given.
						$usersPhone = preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '$1$2$3',$userid->phone2); //clean up the phone number
						$addresses[] = $usersPhone . '@' . $prov_email;
					}else{ //no cell provider was given. We're going to have to try them all.
						$providers = get_providers(); //get the array of providers
						//$prov_emails = array();
						$usersPhone = preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '$1$2$3',$userid->phone2); //get the user's phone number
						foreach ($providers as $provider){
							$prov_value = get_config('cancelcourse', preg_replace('/\s+/','',$provider)); //figure out the provider's email suffix.
							if($prov_value){ //if there's a suffix (prevents attempting to send to unconfigured providers)
								$addresses[] = $usersPhone. '@' . $prov_value;
							}
						}
					}
				}
			}
			return $addresses;
		}
}


//Strips accents from $string
function no_accents($string){ 
	$accents = array("à", "â", "ä", "ç", "è", "é", "ê", "ë", "î", "ï", "ô", "ö", "ù", "û", "ü", "À", "Â", "Ä", "Ç", "È", "É", "Ê", "Ë", "Î", "Ï", "Ô", "Ù", "Û", "Ü");
	$no_accents = array("a" /*à*/, "a" /*â*/, "a" /*ä*/, "c" /*ç*/, "e" /*è*/, "e" /*é*/, "e" /*ê*/, "e" /*ë*/, "i" /*î*/, "i" /*ï*/, "o" /*ô*/, "o" /*ö*/, "u" /*ù*/, "u" /*û*/, "u" /*ü*/, "A" /*À*/, "A" /*Â*/, "A" /*Ä*/, "C" /*Ç*/, "E" /*È*/, "E" /*É*/, "E" /*Ê*/, "E" /*Ë*/, "I" /*Î*/, "I" /*Ï*/, "O" /*Ô*/, "U" /*Ù*/, "U" /*Û*/, "U" /*Ü*/);
	
	$string = str_replace($accents,$no_accents,$string);
	return $string;
}

function send_tweet($ckey,$csecret,$utoken,$usecret,$message){
	/**
	 * Tweets a message from the user whose user token and secret you use.
	 *
	 * Although this example uses your user token/secret, you can use
	 * the user token/secret of any user who has authorised your application.
	 *
	 * Instructions:
	 * 1) If you don't have one already, create a Twitter application on
	 *      https://dev.twitter.com/apps
	 * 2) From the application details page copy the consumer key and consumer
	 *      secret into the place in this code marked with (YOUR_CONSUMER_KEY
	 *      and YOUR_CONSUMER_SECRET)
	 * 3) From the application details page copy the access token and access token
	 *      secret into the place in this code marked with (A_USER_TOKEN
	 *      and A_USER_SECRET)
	 * 4) Visit this page using your web browser.
	 *
	 * @author themattharris
	 */

	if($ckey && $csecret && $utoken && $usecret && $message){
	require_once ('twitter/tmhOAuth.php');
	$tmhOAuth = new tmhOAuth(array(
		'consumer_key'    => $ckey,
		'consumer_secret' => $csecret,
		'user_token'      => $utoken,
		'user_secret'     => $usecret,
	));
	}
	$code = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
		'status' => $message . ' ' . date('Y-m-d')
	));

	if ($code == 200) {
		//var_dump($tmhOAuth->response['response']);
		//tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
		return true;
	}else{
		var_dump($tmhOAuth->response['response']);
		return false;
	}
}
?>