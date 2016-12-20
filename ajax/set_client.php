<?php

$clientAppID  = $_POST['clientAppID'];
$clientSecret = $_POST['clientSecret'];

OC_Appconfig::setValue('user_orcid', 'clientAppID', $clientAppID);
OC_Appconfig::setValue('user_orcid', 'clientSecret', $clientSecret);

OCP\JSON::success();
