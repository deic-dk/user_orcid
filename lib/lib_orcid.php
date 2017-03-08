<?php

namespace OCA\FilesOrcid;

class Lib {
	public static function dbGetUserFromOrcid($orcid){
		if(empty($orcid) || empty(trim($orcid))){
			return '';
		}
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
		return empty($results)?'':$results[0]['userid'];
	}
	
	public static function getUserFromOrcid($orcid) {
		if(\OCP\App::isEnabled('files_sharding') && !\OCA\FilesSharding\Lib::isMaster()){
			$ret = \OCA\FilesSharding\Lib::ws('get_user_from_orcid', array('orcid'=>$orcid),
					true, true, null, 'user_orcid');
			return $ret;
		}
		else{
			return self::dbGetUserFromOrcid($orcid);
		}
	}
	
	public static function dbGetOrcid($user){
		return \OCP\Config::getUserValue($user, 'user_orcid', 'orcid');
	}
	
	public static function getOrcid($user) {
		if(\OCP\App::isEnabled('files_sharding') && !\OCA\FilesSharding\Lib::isMaster()){
			$ret = \OCA\FilesSharding\Lib::ws('get_orcid', array('user'=>$user),
					true, true, null, 'user_orcid');
			return $ret;
		}
		else{
			return self::dbGetOrcid($user);
		}
	}
	
	public static function dbSetOrcid($user, $orcid){
		return \OCP\Config::setUserValue($user, 'user_orcid', 'orcid', $orcid);
	}
	
	public static function setOrcid($user, $orcid) {
		if(\OCP\App::isEnabled('files_sharding') && !\OCA\FilesSharding\Lib::isMaster()){
			$ret = \OCA\FilesSharding\Lib::ws('set_orcid', array('user'=>$user, 'orcid'=>$orcid),
					true, true, null, 'user_orcid');
			return $ret;
		}
		else{
			return self::dbSetOrcid($user, $orcid);
		}
	}
	
}