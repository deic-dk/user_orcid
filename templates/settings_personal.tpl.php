<fieldset id="orcidPersonalSettings" class="section">
	<a id="orcid-info"><?php p($l->t("What's this?"))?></a>
	<h2><!--<img src="/apps/user_orcid/img/orcid.png">-->ORCID</h2>
	<br />
	<div>
	<!--<a href="http://orcid.org">
	<img alt="ORCID logo" src="http://orcid.org/sites/default/files/images/orcid_16x16.png" 
	width="16" height="16" /></a>-->
	<span><?php p($l->t("My ORCID:"))?></span>
	<a class="orcid" href="http://orcid.org/<?php echo $_['orcid'];?>">http://orcid.org/<?php echo $_['orcid'];?></a>
	</div>
	<br />
	<div>
	<button id="connect-orcid-button">
	<img id="orcid-id-logo" src="<?php echo OC::$WEBROOT;?>/apps/user_orcid/img/orcid.png" 
	width='24' height='24' alt="ORCID logo"/><?php p($l->t("Create or connect your ORCID"));?></button>
	</div>
</fieldset>

