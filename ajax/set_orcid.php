<?php

require_once('user_orcid/lib/lib_orcid.php');

$orcid = $_POST['orcid'];
$user = OCP\USER::getUser();

if(OCA\FilesOrcid\Lib::setOrcid($user, $orcid)){
	OCP\JSON::success();
}
else{
	OCP\JSON::error();
}
