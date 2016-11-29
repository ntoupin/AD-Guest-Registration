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



// Initialize session
session_start();
 
function authenticate($user, $password) {
	if(empty($user) || empty($password)) return false;
 
 	// Active Directory IP
	$adServer = "ldaps://";
	// Set your LDAP server url or ip here.  Should be LDAPS not regular LDAP connection - cannot add users over regular non secure.
	// Ex:  $adServer = "ldaps://domain.com";
	
	
	
	
 
	// Active Directory DN
	$base_dn = "";
	// Base domain DN
	// Ex: $base_dn = "DC=domain,DC=com";
	
	// Active Directory dn\
    
	$ldaprdn = '' . "\\" . $user;
					// Set your domain short name for authentication  for the format domain\user
					// Ex:  $ldaprdn = 'domain' . "\\" . $user;
	
	
	// Active Directory Tech user group
	$ldap_user_group = "";
					// Set this for your tech user group that exists in Active Directory - higher than normal users - gives higher "duration" options.
					// Ex: $ldap_user_group = "TechUser";
					
				 
	// Active Directory manager group
	$ldap_manager_group = "";
	// Set this for your tech admin group that exists in Active Directory - higher than normal users - gives higher "duration" options.  Will also be used for admin options in the gui later on.
	// Ex: $ldap_manager_group = "TechSuperAdmin";
					
	
	// Active Directory Staff group
	$ldap_staff_group= "";
	// Set this for your normal user group 
	
	
	
   
	
	// Connect us!
    $ldap = ldap_connect($adServer, 636);
	 ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
	// connect to active directory
	 $bind = @ldap_bind($ldap, $ldaprdn, $password);
 
	// verify user and password
	 if ($bind) {
		// valid
		// check presence in groups
		$filter="(sAMAccountName=$user)";
		$details = array("memberof","sAMAccountName", "cn");
        $result = ldap_search($ldap,$base_dn,$filter,$details);
        ldap_sort($ldap,$result,"sn");
		
		 $info = ldap_get_entries($ldap, $result);
      
		
		
		ldap_unbind($ldap);
 
		
		
		//initialize access as 0
		$access = 0;
		
		// check groups
		foreach($info[0]['memberof'] as $grps) {
			// is superadmin, break loop
			if(strpos($grps, $ldap_manager_group)) { $access = 3; break; } else 
 
			// is tech user
			if(strpos($grps, $ldap_tek_group)){ $access = 2; break;} else
			
			// is staff user
			if(strpos($grps, $ldap_staff_group)){ $access = 1;}
		 	
		
		}
		
		// get name
		foreach($info[0]['cn'] as $cns) {
			
			$displayname = $cns;
 
			
		 	
		
		}
		
		
		
 
		if($access != 0) {
			// establish session variables
			$_SESSION['displayname'] = $displayname;
			$_SESSION['user'] = $user;
			$_SESSION['access'] = $access;
			return true;
		} else {
			// user has no rights
			return false;
		}
 
	  
	} else {
		// invalid name or password
		return false;
	}
}
?>