<?php
//Block_cancelcourse.php (course view)
$string['pluginname'] = 'Cancel Course Block';
$string['cancelcourse'] = 'Cancel Class';
$string['cancelclass'] = '<strong>Cancel Today\'s Class!</strong>';
$string['alreadycancelled'] = '<span style="color:red;"><strong>Class was already cancelled today!</strong></span>';

//Permissions
$string['cancelcourse:addinstance'] = 'Add a Cancel Class block to this class';
$string['cancelcourse:myaddinstance'] = 'Add a Cancel Class block to the My Moodle page'; //It isn't actually possible to assign to the MyMoodle page, but the string is here for completeness.
$string['cancelcoruse:view'] = 'Can view the block';

//Block Global Configuration
$string['headerconfig'] = 'Block Global Settings';
$string['sendtext'] = 'Send SMS?';
$string['sendtextdesc'] = 'Notify students of class cancellations by text (SMS) message.';
$string['providername'] = 'Provider "Short name"';
$string['providerdesc'] = 'Enter the "Short name" of the custom user profile field containing the list of service providers.';
$string['provideremail'] = 'Email-to-SMS address suffix for this provider. Include everything after the "@" symbol (ex: txt.bell.ca).';
$string['sendemail'] = 'Send Email?';
$string['sendemaildesc'] = 'Notify students of class cancellations by email.';
$string['subjectline'] = 'The subject line for the indicated language (languages can be forced per-course, but will default to Moodle\'s default language).';
$string['sendtweet'] = 'Tweet?';
$string['sendtweetdesc'] = 'Tweet a notification of class cancellations.';
$string['ckey'] = 'Consumer Key';
$string['ckeydesc'] = 'The consumer key from your Twitter application (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['csecret'] = 'Consumer Secret';
$string['csecretdesc'] = 'The consumer secret from your Twitter application (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['utoken'] = 'User Token';
$string['utokendesc'] = 'The user token from your Twitter application (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['usecret'] = 'User Secret';
$string['usecretdesc'] = 'The user secret from your Twitter application (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['includeshortname'] = 'Course Short name';
$string['includeshortnamedesc'] = 'Include the course short name in the messages?';
$string['includefullname'] = 'Course Full name';
$string['includefullnamedesc'] = 'Include the course full name in the messages?';
$string['includeprofname'] = 'Professor\'s Name';
$string['includeprofnamedesc'] = 'Include the name of the professor (configured in the block settings).';
$string['multicancel'] = 'Allow multiple class cancellations?';
$string['multicanceldesc'] = 'Allow classes to be cancelled more than once per day? Be carful! This could be confusing to students!';
$string['showcustomtext'] = 'Show custom text field?';
$string['showcustomtextdesc'] = 'Allow teachers to enter custom text to be appended to the email message.<br>This text is not included in SMS-messages or tweets.';
$string['adminemails'] = 'Administrator emails';
$string['adminemailsdesc'] = 'A comma-separated list of email addresses that will always be notified of a course cancellation';

//settingslib.php strings
$string['novalidprovider'] = 'The <strong>Provider "Short name"</strong> field is either empty, or does not contain a valid custom user profile field short name.<br>Sending text messages will not be possible until this field is properly configured.';
$string['emailconfigerror'] = 'The <strong>SMTP hosts</strong> field in Settings->Plugins->Message outputs->Email is empty.<br>Sending emails and text messages will not be possible until this field is properly configured.';
$string['tweetconfigerror'] = 'The <strong>Send Tweet</strong> field is checked, but one of the configuration fields is empty. For tweeting to function, the <strong>Consumer Key</strong>, <strong>Consumer Secret</strong>, <strong>User Token</strong> and <strong>User Secret</strong> fields must all be configured with the appropriate values from <a href="https://dev.twitter.com/apps" style="color:#ffffff;text-decoration:underline;" target="_blank">https://dev.twitter.com/apps</a>.';
$string['cancelcoursedescription'] = '<h5>To send notification of cancelled classes by SMS-message</h5><ol><li>Create a "Menu of choices" custom user profile field in Settings->Users->Accounts->User Profile Fields. Set the "Menu options" to be a list of cellular service providers in your area (You may want to provide an "Uknown" option - the block is design to handle this possibility).</li><li>In the Provider "Short name" (cancelcourse | providername) field on this page, input the Short name you set in the custom user profile field, and save your changes.</li><li>After saving, a new field will appear on this page for each cell provider you configured in the custom user profile field. For each provider, input the Email-to-SMS email address suffix, and save your changes.</li><li>Ensure the "SMTP hosts" (smtphosts) field in Settings->Plugins->Message outputs->Email is configured with at least one functioning SMTP server (only the first server in the list will be used), and that any other SMTP server settings are properly configured.</li><li>Check the "Send SMS?" checkbox on this page, and save the changes. Text message notifications are now configured.</li></ol><h5>To send notification of cancelled classes by email</h5><ol><li>Ensure the "SMTP hosts" (smtphosts) field in Settings->Plugins->Message outputs->Email is configured with at least one functioning SMTP server (only the first server in the list will be used), and that any other SMTP server settings are properly configured.</li><li>Check the "Send Email?" checkbox on this page, and save the changes. Notification by email is now configured.</li></ol><h5>To tweet a notification of cancelled classes</h5><ol><li>Create a twitter app at <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a> and ensure that the app has write permission.</li><li>Copy the Consumer Key, Consumer Secret, User Token and User Secret from the app configuration to the appropriate fields on this page.</li><li>Check the "Tweet?" checkbox, and save the changes. Tweet notifications are now configured.</li></ol><h5>For each installed language, set an appropriate subject line, or leave the subject line boxes empty to use the default (English) subject.<br>This applies to SMS-messages, Emails and Tweets, so you really want to do this!</h5>';
$string['looksgood'] = 'Your current configuration appears to have all the correct settings!';

//Cancel Course Form (confirmation, etc.)
$string['cancelclassfields'] = 'Confirmation';
$string['confirm'] = 'Are you certain you want to cancel class? This CANNOT be undone!';
$string['customtext'] = 'Custom email message text';
$string['customtexthelp'] = 'Custom Text';
$string['customtexthelp_help'] ='An optional message to include in the email notification. This message is not included in SMS-messages or tweets.';
$string['savebutton'] = ' Yes, I want to cancel class! ';
$string['cancelbutton'] = ' No, I don\'t want to cancel class. ';
$string['sending_message_please_wait'] = 'Messages sending. Please don\'t navigate away from this page until you see a confirmation or an error.';

//Course-specific block settings
$string['messagesettings'] = 'Message Settings';
$string['config_language'] = 'Message language';
$string['config_profname'] = 'Professor\'s Name';
$string['none'] = 'Do Not Force';

//View.php strings (when actually cancelling a class - mostly errors and confirmations)
$string['cancelcoursesettings'] = 'Settings';
$string['editpage'] = 'Edit this page';
$string['return_to_class'] = '<strong>Return to class main page</strong>';
$string['cancelthisclass'] = 'Cancel Today\'s Class';
$string['textmessage_sent'] = 'Class cancellation successfully sent by text message!';
$string['textmessage_notsent'] = 'ERROR: Text messages not sent. Please send the following error information to the site administrator: ';
$string['textmessage_configerror'] = 'ERROR: Text messaging is not correctly configured. Please contact the site administrator.';
$string['emailmessage_sent'] = 'Class cancellation successfully sent by email!';
$string['emailmessage_notsent'] = 'ERROR: Email messages not sent. Please send the following error information to the site administrator: ';
$string['emailmessage_configerror'] = 'ERROR: Email messaging is not correctly configured. Please contact the site administrator.';
$string['tweetsuccess'] = 'Class cancellation successfully tweeted!';
$string['tweetfailed'] = 'ERROR: Tweeting failed. Please contact the site administrator.';
$string['twittermessage_configerror'] = 'ERROR: Tweeting is not correctly configured. Please contact the site administrator.';
$string['nosending_error'] = 'ERROR: No sending methods have been selected. Please contact the site administrator.';
$string['dberror'] = 'ERROR: Unable to write date to database. Please contact the site administrator.';
$string['cancelerror'] = 'ERROR: one or more sending methods was not successful (probably because of a configuration error). Please contact the site administrator.';
$string['today'] = 'Today,';
?>