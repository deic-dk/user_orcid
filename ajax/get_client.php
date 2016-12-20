<?php

$clientAppID  = OC_Appconfig::getValue('user_orcid', 'clientAppID');
$clientSecret = OC_Appconfig::getValue('user_orcid', 'clientSecret');

$appUri = \OC::$WEBROOT . 'apps/user_orcid/receive_orcid.php';
if(\OCP\App::isEnabled('files_sharding')){
	$redirectURL = \OCA\FilesSharding\Lib::getMasterURL().$appUri;
}
else{
	$redirectURL = (empty($_SERVER['HTTPS'])?'http':'https') . '://' . $_SERVER['SERVER_NAME'] .
	$appUri;
}

 

OCP\JSON::success(array(
	'redirectURL' => $redirectURL,
	'clientAppID' => $clientAppID,
	'clientSecret' => $clientSecret
));
