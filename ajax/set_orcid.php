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

// obtain current user's id
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    $user_id = \OC::$server->getUserSession()->getUser()->getUID();
}

// set the ORCID via database query

$orcid            = $_POST['orcid'];
$sql    = "INSERT INTO `*PREFIX*user_orcid` (`user_id`, `orcid`) VALUES ('" . $user_id . "', '" . $orcid . "') ON DUPLICATE KEY UPDATE user_id = VALUES(`user_id`), orcid = VALUES(`orcid`)";
$query  = \OCP\DB::prepare($sql); //FIXME: Deprecated. We should use app settings instead.
$result = $query->execute();
return $result;

