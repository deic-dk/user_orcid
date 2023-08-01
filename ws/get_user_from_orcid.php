<?php

OCP\JSON::checkAppEnabled('user_orcid');
OCP\JSON::checkAppEnabled('files_sharding');

$user = OCP\USER::getUser();
$allowedQueryUser = trim(\OCP\Config::getSystemValue('vlantrusteduser', ''));

// This is to allow ScienceRepository/Zenodo to query for user matching orcid
if((empty($user) || $user!=$allowedQueryUser) && !OCA\FilesSharding\Lib::checkIP()){
	http_response_code(401);
	exit;
}

require_once('user_orcid/lib/lib_orcid.php');

$orcid = isset($_REQUEST['orcid'])?$_REQUEST['orcid']:'';

$user = OCA\FilesOrcid\Lib::dbGetUserFromOrcid($orcid);

\OCP\Util::writeLog('user_group_admin', 'Returning user '.$user, \OC_Log::WARN);

OCP\JSON::encodedPrint($user);
