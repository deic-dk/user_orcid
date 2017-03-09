<?php

$clientAppID  = OC_Appconfig::getValue('user_orcid', 'clientAppID');
$clientSecret = OC_Appconfig::getValue('user_orcid', 'clientSecret');

$appUri = \OC::$WEBROOT . '/apps/user_orcid/receive_orcid.php';
$redirectURL = (empty($_SERVER['HTTPS'])?'http':'https') . '://' . $_SERVER['SERVER_NAME'] .
	$appUri;

OCP\JSON::success(array(
	'redirectURL' => $redirectURL,
	'clientAppID' => $clientAppID,
	'clientSecret' => $clientSecret
));
