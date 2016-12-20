<?php

\OCP\Util::writeLog('user_orcid','Received code: '.serialize($_GET), \OC_Log::WARN);

$code = $_GET['code'];

$user = \OCP\User::getUser();

$clientAppID  = OC_Appconfig::getValue('user_orcid', 'clientAppID');
$clientSecret = OC_Appconfig::getValue('user_orcid', 'clientSecret');

$appUri = \OC::$WEBROOT . 'apps/user_orcid/receive_orcid.php';
if(\OCP\App::isEnabled('files_sharding')){
	$redirectURL = \OCA\FilesSharding\Lib::getMasterURL().$appUri;
}
else{
	$redirectURL = (empty($_SERVER['HTTPS'])?'http':'https') . '://' . $_SERVER['SERVER_NAME'] .
	$appUri;
}

$content = "client_id=".$clientAppID."&".
		"client_secret=".$clientSecret."&".
		"grant_type=authorization_code&".
		"code=".$code."&".
		"redirect_uri=".$redirectURL;

$url = "https://orcid.org/oauth/token";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($curl, CURLOPT_UNRESTRICTED_AUTH, TRUE);

$json_response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
if($status===0 || $status>=300 || $json_response===null || $json_response===false){
	\OCP\Util::writeLog('files_sharding', 'ERROR: bad ws response. '.$json_response, \OC_Log::ERROR);
	OCP\JSON::error();
}
else{
	$response = json_decode($json_response, true);
}

\OCP\Util::writeLog('user_orcid','Got token: '.serialize($response), \OC_Log::WARN);

if(!empty($response) && !empty($response['orcid'])){
	\OCP\Config::setUserValue($user, 'user_orcid', 'orcid', $response['orcid']);
	\OCP\Config::setUserValue($user, 'user_orcid', 'access_token', $response['access_token']);
	$tmpl = new OCP\Template("user_orcid", "thanks");
	echo $tmpl->fetchPage();
}
else{
	OCP\JSON::error();
}
