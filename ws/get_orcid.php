<?php

OCP\JSON::checkAppEnabled('user_orcid');
OCP\JSON::checkAppEnabled('files_sharding');

require_once('user_orcid/lib/lib_orcid.php');

if(!OCA\FilesSharding\Lib::checkIP()){
	http_response_code(401);
	exit;
}

$user = $_POST['user'];

$orcid = OCA\FilesOrcid\Lib::dbGetOrcid($user);

OCP\JSON::encodedPrint($orcid);