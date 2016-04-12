
// when we have loaded, get our ORCID from database and set it in the text field
$(document).ready(function() {
	
	// catch clicks on our Save button
	$('#idsubmit').click(function() {
		orcid = document.getElementById('idtextfield').value;
		//alert(orcid);

		$.ajax(OC.linkTo('user_orcid','ajax/set_orcid.php'), {
		 	type:"POST",
		  	data:{
			  orcid: orcid
		 	},
		 	dataType:'json',
		 	success: function(s){
				// what to do upon success
		 	}
	});
	});


	$.ajax(OC.linkTo('user_orcid','ajax/get_orcid.php'), {
		 type:"POST",
		 dataType:'json',
		 success: function(s){
			document.getElementById('idtextfield').value = s['orcid'];
		 }
	});

});
