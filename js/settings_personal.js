var oauthWindow;
var clientAppID;
var clientSecret;
var redirectUrl;

function getClient(){
	$.ajax(OC.linkTo('user_orcid', 'ajax/get_client.php'), {
		type: "GET",
		dataType: 'json',
		success: function(s) {
			clientAppID = s['clientAppID'];
			clientSecret = s['clientSecret'];
			redirectUrl = s['redirectURL'];
		}
	});
}

function openORCID() {
	var oauthWindow = window.open("https://orcid.org/oauth/authorize?"+
		"client_id="+clientAppID+"&response_type=code&scope=/authenticate&"+
		"redirect_uri="+redirectUrl, "_blank", 
		"toolbar=no, scrollbars=yes, width=620, height=600, top=500, left=500");
	/*function refreshParent() {
		oauthWindow.opener.location.reload();
	}
	oauthWindow.onunload = refreshParent;*/
}

function getOrcid(callback){
	$.ajax(OC.linkTo('user_orcid', 'ajax/get_orcid.php'), {
		type: "GET",
		dataType: 'json',
		success: function(s) {
			if(typeof s['orcid'] !== 'undefined'){
				orcid = s['orcid'];
			}
			else{
				orcid = '';
			}
			callback(orcid);
		}
	});
}

function setOrcid(orcid){
	$.ajax(OC.linkTo('user_orcid', 'ajax/set_orcid.php'), {
		type: "POST",
		data: {
			orcid: orcid
			},
			dataType: 'json',
			success: function(s) {
			}
	});
}

function unsetOrcid(){
	$.ajax(OC.linkTo('user_orcid', 'ajax/set_orcid.php'), {
		type: "POST",
		data: {
			orcid: ''
		},
		dataType: 'json',
			success: function(s) {
				$('.has_orcid').hide();
				OC.msg.finishedSaving('#orcid_msg', {status: 'success', data: {message: t("user_orcid", "Disconnected your ORCID")}});
				$('.has_not_orcid').show();
				$('a#orcid').text('');
				$('a#orcid').attr('href', '');
				$('a#orcid').attr('orcid', '');
		}
	});
}

$(document).ready(function() {

	getClient();
	
	if(!$('a#orcid').attr('orcid')){
		$('.has_orcid').hide();
	}
	else{
		$('.has_not_orcid').hide();
	}
	
	$('#set_orcid').click(function(ev){
		openORCID();
	});
	
	$('#unset_orcid').click(function(ev){
		ev.stopPropagation();
		ev.preventDefault();
		unsetOrcid();
	});
	
	$("#orcid-info").click(function (ev) {
		
		var html = "<div><h2>"+t("user_orcid", "About ORCID")+" <img class='orcid_img' src='"+OC.webroot+"/apps/user_orcid/img/orcid.png'></h2>\
				<a class='oc-dialog-close close svg'></a>\
				<div class='about-orcid'></div></div>";

		$(html).dialog({
			  dialogClass: "oc-dialog-orcid",
			  resizeable: true,
			  draggable: true,
			  modal: false,
			  height: 340,
			  width: 420,
				buttons: [{
					"id": "orcidinfo",
					"text": "OK",
					"click": function() {
						$( this ).dialog( "close" );
					}
				}]
			});

		$('body').append('<div class="modalOverlay"></div>');

		$('.oc-dialog-close').live('click', function() {
			$(".oc-dialog-orcid").remove();
			$('.modalOverlay').remove();
		});

		$('.ui-helper-clearfix').css("display", "none");

		$.ajax(OC.linkTo('user_orcid', 'ajax/about_orcid.php'), {
			type: 'GET',
			success: function(jsondata){
				if(jsondata) {
					$('.about-orcid').html(jsondata.data.page);
				}
			},
			error: function(data) {
				alert("Unexpected error!");
			}
		});
	}); 
	
	$(document).click(function(e){
		if (!$(e.target).parents().filter('.oc-dialog-orcid').length && !$(e.target).filter('#orcid-info').length ) {
			$(".oc-dialog-orcid").remove();
			$('.modalOverlay').remove();
		}
	});

});
