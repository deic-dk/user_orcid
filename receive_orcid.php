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
	\OCP\Util::writeLog('user_orcid', 'ERROR: bad ws response. '.$json_response, \OC_Log::ERROR);
	OCP\JSON::error();
}
else{
	$response = json_decode($json_response, true);
}

\OCP\Util::writeLog('user_orcid','Got token: '.serialize($response), \OC_Log::WARN);

function getUserFromORCID($orcid) {
	$result = array();
	$sql = "SELECT * FROM *PREFIX*preferences WHERE appid = ? AND configkey = ? AND configvalue = ?";
	$args = array('user_orcid', 'orcid', $orcid);
	$query = \OCP\DB::prepare($sql);
	$result = $query->execute($args);
	$results = $result->fetchAll();
	if(count($results)>1){
		\OCP\Util::writeLog('user_orcid', 'ERROR: Duplicate entries found for ORCID '.$orcid, \OCP\Util::ERROR);
		return false;
	}
	return $results[0]['userid'];
}

if(!empty($response) && !empty($response['orcid'])){
	if(!\OC_User::isLoggedIn()){
		$user = getUserFromORCID($response['orcid']);
		if(!empty($user)){
			// Successful login
			\OC_Util::teardownFS();
			//\OC\Files\Filesystem::initMountPoints($owner);
			\OC_User::setUserId($user);
			\OC_Util::setupFS($user);
			\OCP\Util::writeLog('user_orcid', 'Logged in user: '.$user.', user: '.\OCP\USER::getUser(), \OC_Log::WARN);
		}
		OC_Util::redirectToDefaultPage();
	}
	else{
		// ORCID setting
		\OCP\Config::setUserValue($user, 'user_orcid', 'orcid', $response['orcid']);
		\OCP\Config::setUserValue($user, 'user_orcid', 'access_token', $response['access_token']);
		$tmpl = new OCP\Template("user_orcid", "thanks");
		echo $tmpl->fetchPage();
	}
}
else{
	if(!\OC_User::isLoggedIn()){
		// Failed login attempt
		OC_Util::redirectToDefaultPage();
	}
	else{
		// Failed ORCID setting
		OCP\JSON::error();
	}
}
