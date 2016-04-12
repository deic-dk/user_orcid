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
    $user_id = OCP\USER::getUser();
}

// get the ORCID via database query

$sql    = "SELECT orcid FROM `*PREFIX*user_orcid_ids` WHERE `*PREFIX*user_orcid_ids`.`user_id` = '" . $user_id . "'";
//TODO: needs to handle non-preexisting ids 
$query  = \OCP\DB::prepare($sql);
$output = $query->execute();

$row    = $output->fetchRow();
$result = $row['orcid'];

OCP\JSON::success(array('orcid' => $result));

