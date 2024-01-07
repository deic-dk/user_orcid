<?php

OCP\JSON::checkAppEnabled('user_orcid');
OCP\JSON::checkAppEnabled('files_sharding');
OCP\JSON::checkAppEnabled('chooser');

$user = OCP\USER::getUser();
$allowedQueryUser = trim(\OCP\Config::getSystemValue('vlantrusteduser', ''));

// This is to allow ScienceRepository/Zenodo to query for user matching orcid
if(empty($user)){
	$user = \OC_Chooser::checkIP();
}
if(empty($user) || $user!=$allowedQueryUser){
	if(!OCA\FilesSharding\Lib::checkIP()){
		\OCP\Util::writeLog('user_orcid', 'User '.$user.'/'.$_SERVER['PHP_AUTH_USER'].' not allowed from '.$_SERVER['REMOTE_ADDR'], \OC_Log::WARN);
		http_response_code(401);
		exit;
	}
}

require_once('user_orcid/lib/lib_orcid.php');

$orcid = isset($_REQUEST['orcid'])?$_REQUEST['orcid']:'';

$lookedUpUser = OCA\FilesOrcid\Lib::dbGetUserFromOrcid($orcid);

\OCP\Util::writeLog('user_orcid', 'Returning user '.$lookedUpUser, \OC_Log::WARN);

OCP\JSON::encodedPrint($lookedUpUser);
