<?php

$user = \OCP\User::getUser();
$tmpl = new OCP\Template('user_orcid', 'settings_personal.tpl');

$orcid = \OCP\Config::getUserValue($user, 'user_orcid', 'orcid');
$tmpl->assign('orcid', $orcid);
$orcid_token = \OCP\Config::getUserValue($user, 'user_orcid', 'orcid_token');
$tmpl->assign('orcid_token', $orcid_token);

OCP\Util::addScript('user_orcid', 'settings_personal');
OCP\Util::addStyle('user_orcid', 'style');

return $tmpl->fetchPage();
