# user_orcid
ORCID authentication and retrieval

Written 2016 by Lars Næsbye Christensen, DeIC

an ownCloud app that lets a user authenticate with ORCID (orcid.org) for use in e.g. archiving.

## Dependencies 
 * ownCloud 7.0.x (not tested with later versions)

## Installation instructions
Copy the app files to the **owncloud/apps/** directory.

## Usage
Under User Settings you can enter your ORCID and store it for use in other apps. The ORCID is validated against both length and checksum as per the ISO/IEC 7064:2003, MOD 11-2.

## Status

Not fully functional as of yet.

### How it works (when we've got it done)

 - When the user clicks the 'Confirm ORCID' button, they are taken to orcid.org (in a new window) for authentication.
 - After successful login and authentication, orcid.org service sends data back to owncloud via access token.
 - The token is used to obtain ORCID and associated name from the service.
 - The user's ORCID is then stored in the owncloud database for access by other apps, and displayed next to the button.


