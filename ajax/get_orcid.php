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

// get the ORCID via database query

$sql    = "SELECT orcid FROM `*PREFIX*user_orcid` WHERE `*PREFIX*user_orcid`.`user_id` = '" . $user_id . "'";

$query  = \OCP\DB::prepare($sql); //FIXME: Deprecated. We should use app settings instead.
$output = $query->execute();

$row    = $output->fetchRow();
$result = $row['orcid'];

OCP\JSON::success(array('orcid' => $result)); //FIXME: deprecated in 8.1: Use a AppFramework JSONResponse instead

