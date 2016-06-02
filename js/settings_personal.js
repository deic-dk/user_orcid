$(document).ready(function() {
        authURLprefix = "https://sandbox.orcid.org/oauth/authorize";
        exchURLprefix = "https://pub.sandbox.orcid.org/oauth/token";
        useURLprefix = "http://pub.sandbox.orcid.org/v1.2";
        redirectURL = "https://developers.google.com/oauthplayground";
clientAppID = "";
clientSecret ="";
    // if stored, get our ORCID from database and put it in the text field
    $.ajax(OC.linkTo('user_orcid', 'ajax/get_orcid.php'), {
        type: "GET",
        dataType: 'json',
        success: function(s) {
            orcid = s['orcid'];
            document.getElementById('idtextfield').value = orcid;
            if (orcid != null) {
                document.getElementById('orcidstatus').style.color = "green";
                document.getElementById('orcidstatus').innerHTML = "<a href='https://orcid.org/" + s['orcid'] + "' target='_blank'> Go to web entry for this ORCID.</a>";
            }
        }
    });

    // catch clicks on our Confirm ORCID button
    $('#idsubmit').click(function() {

    $.ajax(OC.linkTo('user_orcid', 'ajax/get_client.php'), {
        type: "GET",
        dataType: 'json',
        success: function(s) {
            clientAppID = s['clientAppID'];
            clientSecret = s['clientSecret'];	    

}
    });

        /*authURL = authURLprefix + "?client_id=" + clientAppID + "&response_type=code&scope=/authenticate&redirect_uri=" + redirectURL;

        window.open(authURL, "_blank");*/

        // store our received values in database for future use, needs addition of name
        $.ajax(OC.linkTo('user_orcid', 'ajax/set_orcid.php'), {
            type: "POST",
            data: {
                orcid: orcid
            },
            dataType: 'json',
            success: function(s) {
                document.getElementById('orcidstatus').style.color = "green";
                document.getElementById('orcidstatus').innerHTML = "Validated and stored. <a href='https://orcid.org/" + orcid + "' target='_blank'> Go to web entry for this ORCID.</a>";
            }
        });


    });



});

