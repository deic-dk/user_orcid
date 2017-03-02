<?php

OCP\JSON::checkAppEnabled('user_orcid');
OCP\JSON::checkAppEnabled('files_sharding');

if(!OCA\FilesSharding\Lib::checkIP()){
	http_response_code(401);
	exit;
}

$user = $_POST['user'];

$orcid = OCA\FilesOrcid\Lib::dbGetOrcid($user);

OCP\JSON::encodedPrint($orcid);