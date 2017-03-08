<?php

\OCP\Util::writeLog('user_orcid','Received code: '.serialize($_GET), \OC_Log::WARN);

require_once('user_orcid/lib/lib_orcid.php');

$code = $_GET['code'];

$user = \OCP\User::getUser();

$clientAppID  = OC_Appconfig::getValue('user_orcid', 'clientAppID');
$clientSecret = OC_Appconfig::getValue('user_orcid', 'clientSecret');

$appUri = \OC::$WEBROOT . '/apps/user_orcid/receive_orcid.php';
$redirectURL = (empty($_SERVER['HTTPS'])?'http':'https') . '://' . $_SERVER['SERVER_NAME'] .
	$appUri;

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
	\OCP\Util::writeLog('user_orcid','Got token: '.serialize($response), \OC_Log::WARN);
}

if(!empty($response) && !empty($response['orcid'])){
	if(!\OC_User::isLoggedIn()){
		$user = OCA\FilesOrcid\Lib::getUserFromOrcid($response['orcid']);
		if(!empty($user)){
			// Successful login
			if(OCP\App::isEnabled('files_sharding') && \OCA\FilesSharding\Lib::isMaster()){
				$userServer = OCA\FilesSharding\Lib::getServerForUser($user);
				if(!empty($userServer)){
					$parsedRedirect = parse_url($userServer);
					if($_SERVER['HTTP_HOST']!==$parsedRedirect['host']){
						$redirect = $userServer;
						$orcidClientAppID  = OC_Appconfig::getValue('user_orcid', 'clientAppID');
					}
				}
			}
			if(!empty($redirect)){
				\OC_User::setUserId($user);
				// Redirect (and relogin on slave)
				$url = "https://orcid.org/oauth/authorize?client_id=".
				$orcidClientAppID."&response_type=code&scope=/authenticate&redirect_uri=".
				rtrim($userServer, '/')."/apps/user_orcid/receive_orcid.php";
				header('Location: '.$url);
				exit();
			}
			else{
				// Local user
				\OC_Util::teardownFS();
				//\OC\Files\Filesystem::initMountPoints($owner);
				\OC_User::setUserId($user);
				\OC_Util::setupFS($user);
				\OCP\Util::writeLog('user_orcid', 'Logged in user: '.$user.', user: '.\OCP\USER::getUser(), \OC_Log::WARN);
				OC_Util::redirectToDefaultPage();
			}
		}
		else{
			failedLogin();
		}
	}
	else{
		// ORCID setting
		OCA\FilesOrcid\Lib::setOrcid($user, $response['orcid']);
		//\OCP\Config::setUserValue($user, 'user_orcid', 'access_token', $response['access_token']);
		$tmpl = new OCP\Template("user_orcid", "thanks");
		echo $tmpl->fetchPage();
	}
}
else{
	if(!\OC_User::isLoggedIn()){
		// Failed login attempt
		failedLogin();
	}
	else{
		// Failed ORCID setting
		OCP\JSON::error();
	}
}

//////////////////////////

function failedLogin(){
	$location = empty(OC::$WEBROOT)?'/':OC::$WEBROOT;
	$message = "Login with ORCID failed. ".
			"Notice: You must first log in via institution, then attach your ORCID ID in your settings.";
	header('Location: '.$location."?message=".urlencode($message));
	exit();
}
