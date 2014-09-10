<?php
//Block_cancelcourse.php (course view)
$string['pluginname'] = 'Bloc : Annulation de classe';
$string['cancelcourse'] = 'Annuler la classe';
$string['cancelclass'] = '<strong>Annuler la classe d\'aujourd\'hui</strong>';
$string['alreadycancelled'] = '<span style="color:red;"><strong>La class a déjà été annulée aujourd\'hui!</strong></span>';

//Permissions
$string['cancelcourse:addinstance'] = 'Ajouter le bloc « Annulation de classe » à ce cours';
$string['cancelcourse:myaddinstance'] = 'Ajouter le block « Annulation de classe » à Ma page'; //It isn't actually possible to assign to the MyMoodle page, but the string is here for completeness.
$string['cancelcoruse:view'] = 'Peut voir le bloc';

//Block Global Configuration
$string['headerconfig'] = 'Paramètres globaux du bloc';
$string['sendtext'] = 'Envoyer message texte?';
$string['sendtextdesc'] = 'Avertir les étudiants de l\'annulation de la classe par message texte.';
$string['providername'] = '« Nom abrégé » du champ des fournisseurs';
$string['providerdesc'] = 'Entrer le « Nom abrégé » du champ du profil customizé qui contient la liste des fournisseurs de service cellulaire.';
$string['provideremail'] = 'Suffixe de l\'adresse Courriel-à-SMS de ce fournisseur. Il faut inclure tout ce qui apparaît après le symbol @ (ex: txt.bell.ca).';
$string['sendemail'] = 'Envoyer courriels?';
$string['sendemaildesc'] = 'Avertir les étudiants de l\'annulaition de la classe par courriel.';
$string['subjectline'] = 'Le sujet du courriel pour la langue spécifiée (la langue peut être forcée par cours, mais le message utilise normalement la langue défaut de Moodle).';
$string['sendtweet'] = 'Tweeter?';
$string['sendtweetdesc'] = 'Tweeter la notification de l\'annulation de classe.';
$string['ckey'] = '« Consumer Key »';
$string['ckeydesc'] = 'La clé consommatrice (« Consumer Key») de votre application Twitter (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['csecret'] = '« Consumer Secret »';
$string['csecretdesc'] = 'Le secret consommateur (« Consumer secret ») de votre application Twitter (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['utoken'] = 'Jeton d\'utilisateur';
$string['utokendesc'] = 'Le jeton d\'utilisateur (« User token ») de votre application Twitter (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['usecret'] = '« Secret d\'utilisateur »';
$string['usecretdesc'] = 'Le secret d\'utilisateur (« User Secret ») de votre application Twitter (<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>).';
$string['includeshortname'] = 'Nom abrégé du cours';
$string['includeshortnamedesc'] = 'Inclure le nom abrégé du cours dans le message?';
$string['includefullname'] = 'Nom complet du cours';
$string['includefullnamedesc'] = 'Inclure le nom complet du cours dans le message?';
$string['includeprofname'] = 'Nom du professeur';
$string['includeprofnamedesc'] = 'Inclure le nom du professeur (configuré dans les paramètres du bloc.';
$string['multicancel'] = 'Permettre plusieurs annulations par jour?';
$string['multicanceldesc'] = 'Permettre aux utilisateurs d\'annuler une classe plus qu\'une fois par jour? Attention! Cela peut être mêlant pour les étudiants!';
$string['showcustomtext'] = 'Montrer le champ du texte customizé?';
$string['showcustomtextdesc'] = 'Permettre aux enseignants d\'ajouter du texte customizé au courriel. <br>Ce texte ne sera inclus ni dans les messages textes, ni dans les tweets.';
$string['adminemails'] = 'Courriels d\'administrateurs';
$string['adminemailsdesc'] = 'Une liste de courriels (séparés par des virgules) qui seront toujours avertis de l\'annulation d\'une classe.';

//settingslib.php strings
$string['novalidprovider'] = 'Le champ du <strong>Nom abrégé des fournisseurs</strong> est vide, ou ne contient pas le nom abrégé valide du champ customizé du profil.<br>L\'envoi des courriel et des messages textes ne sera pas possible jusqu\'à ce que ce champ soit bien configuré.';
$string['emailconfigerror'] = 'Le champ <strong>Hôtes SMTP</strong> dans Paramètres->Plugins->Output des messages->Courriel est vide.<br>L\'envoi des courriels des messages textes ne sera  pas possible jusqu\'à ce que ce champ soit bien configuré.';
$string['tweetconfigerror'] = 'Le champ <strong>Tweeter?</strong> est coché, mais un des champs de configuration relié est vide. Pour faire fonctionner des tweets, les champs <strong>Consumer Key</strong>, <strong>Consumer Secret</strong>, <strong>User Token</strong> et <strong>User Secret</strong> doivent tous être configurés avec les valeurs nécessaires du site <a href="https://dev.twitter.com/apps" style="color:#ffffff;text-decoration:underline;" target="_blank">https://dev.twitter.com/apps</a>.';
$string['cancelcoursedescription'] = '
<h5>Pour envoyer la notification de l\'annulation de classe par message texte (SMS)</h5><ol><li>Créez un « Menu déroulant » dans Paramètres->Utilisateurs->Comptes->Champs du profil. La liste doit contenir les noms des fournisseurs de service cellulaire dans votre région (vous voulez peut-être ajouter une option « inconnu » - le bloc est configurer pour réagir à cette possibilité).</li><li>Dans le champ du « Nom abrégé » (cancelcourse | providername) sur cette page, insérez le Nom abrégé que vous avez mis dans le champ du profil customizé, et ensuite, enregistrez vos modifications.</li><li>Après avoir enregistré les modifications, un nouveau champ va apparaître pour chaque fournisseur de service cellulaire que vous avez configuré dans le champ du profil customizé. Pour chaque fournisseur, mettre le suffixe de l\'adresse courriel-à-message-texte et ensuite enregistrez vos modifications.</li><li>Assurez-vous que le champ « Hôtes SMTP » (smtphosts) dans Paramètres->Plulgins->Output des messages->Courriel est configuré avec l\'adresse d\'au moins un serveur SMTP fonctionnel (seulement le premier serveur dans la liste sera utilisé), et que tous les autres paramètres du serveur SMTP sont bien configurés.</li><li>Cochez le champ « Envoyer message texte? » sur cette page et enregistrez les modifications. L\'envoi des messages textes est maintenant configuré.</li></ol><h5>Pour envoyer la notification de l\'annulation de classe par courriel</h5><ol><li>Assurez-vous que le champ « Hôtes SMTP » (smtphosts) dans Paramètres->Plugins->Output des messages->Courriel est configuré avec l\'adresse d\'au moins un serveur SMTP fonctionnel (seulement le premier serveur dans la liste sera utilisé), et que tous les autres paramètres du serveur SMTP sont bien configurés.</li><li>Cochez le champ « Envoyez courriels? » sur cette page, et ensuite enregistrez les modifications. L\'envoi de la notification par courriel est maintenant configuré.</li></ol><h5>Pour tweeter la notification de l\'annulation de classe</h5><ol><li>Créez une application Twitter au site web <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a> et assurez-vous que l\'application a la permission d\'écriture (« write permission »).</li><li>Copiez les <strong>Consumer Key</strong>, <strong>Consumer Secret</strong>, <strong>User Token</strong> et <strong>User Secret</strong> et collez-les dans les champs appropriés sur cette page.</li><li>Cochez le champs « Tweeter? », et enregistrez les modifications. Les notifications par tweets sont maintenant configurées.</li></ol><h5>Pour chaque langue installée, mettez un sujet du courriel approprié, ou laissez le sujet vide pour utiliser le défaut (Anglais).<br>Ce paramètre s\'aplique aux messages textes, courriel et tweets, donc vous ne voulez probablement pas sauter cette étape!<h5>';
$string['looksgood'] = 'La configuration actuelle semble être en ordre!';

//Cancel Course Form (confirmation, etc.)
$string['cancelclassfields'] = 'Confirmation';
$string['confirm'] = 'Êtes-vous certain de vouloir annuler cette classe? C\'est impossible d\'arrêter l\'envoi du message!';
$string['customtext'] = 'Texte du courriel customizé';
$string['customtexthelp'] = 'Texte customizé';
$string['customtexthelp_help'] ='Un message (facultatif) à inclure dans le courriel. Ce message ne sera inclus ni dans des messages textes, ni dans des tweets.';
$string['savebutton'] = ' Oui, je veux annuler la classe d\'aujourd\'hui! ';
$string['cancelbutton'] = ' Non, je ne veux pas annuler cette classe. ';
$string['sending_message_please_wait'] = 'L\'envoi des messages en cours. Veuillez ne pas sortir de cette page jusqu\'à ce que vous voyez un message de confirmation ou une erreur.';

//Course-specific block settings
$string['messagesettings'] = 'Paramètres du message';
$string['config_language'] = 'Langue du message';
$string['config_profname'] = 'Nom du professeur';
$string['none'] = 'Ne pas imposer';

//View.php strings (when actually cancelling a class - mostly errors and confirmations)
$string['cancelcoursesettings'] = 'Paramètres';
$string['editpage'] = 'Modifier la page';
$string['return_to_class'] = 'Retourner à la page principale du cours';

$string['cancelthisclass'] = 'Annuler la classe d\'aujourd\'hui';
$string['textmessage_sent'] = 'L\'envoi de l\'annulation de classe par message texte a réussi!';
$string['textmessage_notsent'] = 'ERREUR : Impossible d\'envoyer les messages textes. Veuillez transférer l\'information suivante à l\'administrateur du système : ';
$string['textmessage_configerror'] = 'ERREUR : L\'envoi par message texte n\'est pas bien configuré. Veuillez contacter l\'administrateur du système.';
$string['emailmessage_sent'] = 'L\'envoi de l\'annulation de classe par courriel a réussi!';
$string['emailmessage_notsent'] = 'ERREUR : Impossible d\'envoer les courriels Veuillez transférer l\'information suivante à l\'administrateur du système : ';
$string['emailmessage_configerror'] = 'ERREUR : L\'envoi par courriel n\'est pas bien configuré. Veuillez contacter l\'administrateur du système.';
$string['tweetsuccess'] = 'Le tweet de l\'annulation de classe par a réussi!';
$string['tweetfailed'] = 'ERREUR : Impossible de tweeter. Veuillez contacter l\'administrateur du système.';
$string['twittermessage_configerror'] = 'ERREUR : l\'intégration avec Twitter n\'est pas bien configurée. Veuillez contacter l\'administrateur du système.';
$string['nosending_error'] = 'ERREUR : Aucun méthode d\'envoi de message est sélectionné. Veuillez contacter l\'administrateur du système.';
$string['dberror'] = 'ERREUR : Impossible d\'écrire à la base de données. Veuillez contacter l\'administrateur du système.';
$string['cancelerror'] = 'ERREUR : un (ou plusieurs) méthode d\'envoi n\'a pas réussi (probablement à cause d\'une erreur de configuration). Veuillez contacter l\'administrateur du système.';
$string['today'] = 'aujourd\'hui,';
?>