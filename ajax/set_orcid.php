<?php

$orcid = $_POST['orcid'];

\OCP\Config::setUserValue(\OC::$server->getUserSession()->getUser()->getUID(),
		'user_orcid', 'orcid', $orcid);

OCP\JSON::success();
