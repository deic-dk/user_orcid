function generateCheckDigit(orcid_no_hyphens) {
    // Generates check digit as per ISO 7064 11,2 for 15 digit string
    // http://support.orcid.org/knowledgebase/articles/116780-structure-of-the-orcid-identifier
    var total = 0;
    var zero = "0".charCodeAt(0);
    for (var i = 0; i < 15; i++) {
        var digit = orcid_no_hyphens.charCodeAt(i) - zero;
        total = (total + digit) * 2;
    }
    var result = (12 - (total % 11)) % 11;
    return (result == 10 ? "X" : String(result));
}

function invalidORCID(orcid) {
    // False if orcid has correct form (including hyphens) and valid checksum, else error string
    var orcid_no_hyphens = orcid.replace(/^(\d{4})-(\d{4})-(\d{4})-(\d\d\d[\dX])$/, "$1$2$3$4");
    if (orcid_no_hyphens == orcid) { // will not match if replace succeeded
        document.getElementById('orcidstatus').style.color = "red";
        document.getElementById('orcidstatus').innerHTML = "Invalid ORCID, bad form";
        return true;
    }
    if (orcid_no_hyphens.charAt(15) != generateCheckDigit(orcid_no_hyphens)) {
        document.getElementById('orcidstatus').style.color = "red";
        document.getElementById('orcidstatus').innerHTML = "Invalid ORCID, bad checksum";
        return true;
    }
    return false;
}


// when we have loaded, get our ORCID from database and set it in the text field
$(document).ready(function() {

    // catch clicks on our Confirm button
    $('#idsubmit').click(function() {
        orcid = document.getElementById('idtextfield').value;

        if (!invalidORCID(orcid))

        {
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

        }
    });


    $.ajax(OC.linkTo('user_orcid', 'ajax/get_orcid.php'), {
        type: "POST",
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

});

