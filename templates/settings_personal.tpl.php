<fieldset id="orcidPersonalSettings" class="section">
	<a id="orcid-info"><?php p($l->t("What's this?"))?></a>
	<h2>ORCID &nbsp; <img src="/apps/user_orcid/img/orcid.png"></h2>
	<br />
	<div class="has_orcid">
	<!--<a href="http://orcid.org">
	<img alt="ORCID logo" src="http://orcid.org/sites/default/files/images/orcid_16x16.png" 
	width="16" height="16" /></a>-->
	<span><?php p($l->t("My ORCID:"))?></span>
	<a id="orcid" orcid="<?php echo $_['orcid'];?>" href="http://orcid.org/<?php echo $_['orcid'];?>">http://orcid.org/<?php echo $_['orcid'];?></a>
	<div id="unset_orcid" class="delete-selected btn" title="<?php p($l->t('Disconnect ORCID'))?>"><i class="icon-trash"></i></div>
	</div>
	<br />
	<div class="has_not_orcid">
	<button id="set_orcid">
	<img id="orcid-id-logo" src="<?php echo OC::$WEBROOT;?>/apps/user_orcid/img/orcid.png" 
	width='24' height='24' alt="ORCID logo"/><?php p($l->t("Connect your ORCID"));?></button>
	</div>
	<div id="orcid_msg"></div>
</fieldset>

