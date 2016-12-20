<?php

OCP\JSON::checkLoggedIn();
OCP\JSON::checkAppEnabled('user_orcid');
OCP\JSON::callCheck();

$tmpl = new OCP\Template("user_orcid", "about");
$page = $tmpl->fetchPage();
OCP\JSON::success(array('data' => array('page'=>$page)));
