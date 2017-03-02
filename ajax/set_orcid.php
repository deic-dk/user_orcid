<?php

$orcid = $_POST['orcid'];
$user = OCP\USER::getUser();

if(OCA\FilesOrcid\Lib::setOrcid($user, $orcid)){
	OCP\JSON::success();
}
else{
	OCP\JSON::error();
}
