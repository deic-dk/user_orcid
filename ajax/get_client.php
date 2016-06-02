<?php
/*
 * user_orcid, authentication with ORCID
 *
 * Written 2016 by Lars N\xc3\xa6sbye Christensen, DeIC
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// get the client ID and secret via app settings

$clientAppID = OC_Appconfig::getValue('user_orcid', 'clientAppID');
$clientSecret = OC_Appconfig::getValue('user_orcid', 'clientSecret');

OCP\JSON::success(array('clientAppID' => $clientAppID, 'clientSecret' => $clientSecret));

