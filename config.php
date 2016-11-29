<?php
/*  

 This file is part of ADGR (Active Directory Guest Registration).

    Guest-ad-account-creation is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Guest-ad-account-creation is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ADGR.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once('authenticate.php');



if (strpos($_SERVER['SCRIPT_NAME'], 'login.php') == false){ // not on login page...
if(empty($_SESSION['user'])){ 
       header('Location: login.php'); 
       die("You are not logged in."); 
 } 

}

$base = $_SERVER['DOCUMENT_ROOT'];
$home = $base. '';  
// Set your base url path here - this includes anything after your domain. 
// Ex: if this script was located at  http://www.google.com/wifi-account-creation/index.php this should be set as:  /wifi-account-creation/  
// INCLUDE THE TRAILING SLASH  

$url = '';
// Set the full url path here - include http://
// Ex: if this script was located at  http://www.google.com/wifi-account-creation/index.php this should be set as:  http://www.google.com/wifi-account-creation/
// INCLUDE THE TRAILING SLASH 


	
/* Misc config */
$date = date('Y-m-d H:i:s');



 
/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

 
?>