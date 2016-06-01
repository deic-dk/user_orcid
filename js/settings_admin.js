
$(document).ready(function() {
// catch clicks on our 'Store OaAuth' values button

   $('#clientsubmit').click(function() {

        inputclientappid = document.getElementById('inputclientappid').value;
        inputclientsecret = document.getElementById('inputclientsecret').value;
	alert(inputclientappid);
	alert(inputclientsecret);
    });

});

