<head>
		<title>Thanks</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600,700,800">
		<link rel="stylesheet" href="<?php echo(OC::$WEBROOT);?>/core/css/styles.css?v=cf866614b6b18cda13fe699a3a65661b" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo(OC::$WEBROOT);?>/core/css/fonts.css?v=cf866614b6b18cda13fe699a3a65661b" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo(OC::$WEBROOT);?>/core/css/apps.css?v=cf866614b6b18cda13fe699a3a65661b" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo(OC::$WEBROOT);?>/core/css/fixes.css?v=cf866614b6b18cda13fe699a3a65661b" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo(OC::$WEBROOT);?>/core/css/jquery.ocdialog.css?v=cf866614b6b18cda13fe699a3a65661b" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo(OC::$WEBROOT);?>/apps/user_orcid/css/style.css?v=cf866614b6b18cda13fe699a3a65661b" type="text/css" media="screen">
</head>

<div class='orcid-popup'>
	<h1>
		Thank you for connecting your ORCID <img class="orcid_img" src="<?php echo OC::$WEBROOT;?>/apps/user_orcid/img/orcid.png" />
	</h1>
</div>

<script>
function refreshParent() {
	window.opener.location.reload();
}
window.onunload = refreshParent;
setTimeout(function(){
	window.close();
}, 3000);
</script>