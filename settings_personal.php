<?php

require_once('user_orcid/lib/lib_orcid.php');

$user = \OCP\User::getUser();
$tmpl = new OCP\Template('user_orcid', 'settings_personal.tpl');

$orcid = OCA\FilesOrcid\Lib::getOrcid($user);

$tmpl->assign('orcid', $orcid);

OCP\Util::addScript('user_orcid', 'settings_personal');
OCP\Util::addStyle('user_orcid', 'style');

return $tmpl->fetchPage();
