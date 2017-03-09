<?php

require_once('user_orcid/lib/lib_orcid.php');

$user = $_POST['user'];

$orcid = OCA\FilesOrcid\Lib::getOrcid($user);

if(!empty($orcid)){
	OCP\JSON::success(array('orcid' => $orcid));
}
else{
	OCP\JSON::error(array('orcid' => ''));
}
