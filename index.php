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




require_once('config.php');

// Pass logging out
			if(isset($_GET['logout'])) {
				
				// Log Variables 
				$user = $_SESSION['user'];
				$type = "Logout";
				
				
				
		
				
				// destroy session
				session_unset();
				$_SESSION = array();
				unset($_SESSION['user'],$_SESSION['access'],$_SESSION['displayname']);
				session_destroy();
				header("Location: login.php");
			}
			
			



include ('navigation.php');
			


// Register Form
// -------------- Set Register
	if(isset($_GET['registered'])) {
		
// --------------------- Posted First Name, form submitted
		
			if(isset($_POST['fname'])){
				
				// AD Admin Credentials for creating user
				
				$user = "";
				$password = '';
				// Set your domain  user credentials here - must be a user that has permission to create and move active directory users.
				
				
				
				// From Form
				
				$sponsor = $_SESSION['user'];
				
					
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$name = $fname . $lname;
					$purpose = $sponsor.": ".$_POST['purpose'];
					$location = $_POST['location'];
					$guestusername = $_POST['guestusername'];
					
					$account = "" . $guestusername;
					// Enter your account prefix in the double quotes above, this will make all guest usernames the prefix then their created name.
					// Ex: $account = "Guest_" . $guestusername;
					$pwdtxt = $_POST['guestpassword'];
					$guestdn = "CN=".$name.",";
					// Set your DN in the double quotes above for the desired OU of the created accounts. 
					// Ex:  $guestdn = "CN=".$name.",OU=Guest,DC=domain,DC=com";
					
					
					## Create Unicode password
					$newPassword = "\"" . $pwdtxt . "\"";
					$len = strlen($newPassword);
					$newPassw = "";
					
					for($i=0;$i<$len;$i++) {
						$newPassw .= "{$newPassword{$i}}\000";
					}
				
				
				// Setting up account expiration
				
				$currentTimeUnix = time(); //time of post
				$secondsBetween1601and1970 = 11644473600;
				
				if ($_POST['length'] != "1 Hour"){
				
						// How many days? 
						$dayseconds = "86400";
						$expireseconds = $_POST['length'] * $dayseconds ;
				} else {
						// 1 hour
						$expireseconds = "3600" ;
				}
						
				
				
				$timesAdded = $currentTimeUnix + $secondsBetween1601and1970 + $expireseconds;
				$nanoseconds = $timesAdded * 10000000; 
				
				// When will it expire?... In English
				$dt = new DateTime('now + '.$_POST['length']);
				
				
					// Active Directory Connection Later to be moved to config files instead of base -------------------------
				
				
				
				
				
				
				
				
				// Active Directory IP
						$adServer = "ldaps://";
						// Set your LDAP server url or ip here.  Should be LDAPS not regular LDAP connection - cannot add users over regular non secure.
						// Ex:  $adServer = "ldaps://domain.com";
					
					
				 
					// Active Directory DN
					$base_dn = "DC=domain,DC=com";
					// Set your base DN in the double quotes above  
					// Ex:  $base_dn = "DC=domain,DC=com";
					
					// Active Directory domain name 
					$ldaprdn = '' . "\\" . $user;
					// Set your domain short name for authentication  for the format domain\user
					// Ex:  $ldaprdn = 'domain' . "\\" . $user;
				
					
					// Active Directory user group 
					$ldap_user_group = "";
					// Set this for your tech user group that exists in Active Directory - higher than normal users - gives higher "duration" options.
					// Ex: $ldap_user_group = "TechUser";
					
				 
					// Active Directory manager group
					$ldap_manager_group = "";
					// Set this for your tech admin group that exists in Active Directory - higher than normal users - gives higher "duration" options.  Will also be used for admin options in the gui later on.
					// Ex: $ldap_manager_group = "TechSuperAdmin";
					
					
					
					
				   
					
					// Connect us --- do not edit below this 
					$ldap = ldap_connect($adServer, 636);
					 ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
					// connect to active directory
					 $bind = @ldap_bind($ldap, $ldaprdn, $password);
					 
					
						// valid
						// check presence in groups
						$filter="(sAMAccountName=$account)";
						$details = array("sAMAccountName");
						$result = ldap_search($ldap,$base_dn,$filter,$details);
						ldap_sort($ldap,$result,"sn");
						
						 $info = ldap_count_entries($ldap, $result);
						 
							ldap_close($ldap);
							
					  
// ----------------------  If account DOESN'T EXIST						 					
	 if ($info !=1){						
						
						// Connect us!
					$ldap = ldap_connect($adServer, 636);
					 ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
					// connect to active directory
					 $bind = @ldap_bind($ldap, $ldaprdn, $password);
				 
					
						
						
							$ldaprecord['cn'] = $name;
							$ldaprecord['givenName'] = $fname;
							$ldaprecord['sn'] = $lname;
							$ldaprecord['objectclass'][0] = "top";
							$ldaprecord['objectclass'][1] = "person";
							$ldaprecord['objectclass'][1] = "organizationalPerson";
							$ldaprecord['objectclass'][2] = "user";
							$ldaprecord["accountExpires"] = $nanoseconds;
							$ldaprecord["description"] = $purpose;
							$ldaprecord["physicalDeliveryOfficeName"] = $location;
												
							$ldaprecord["unicodepwd"] = $newPassw;
							$ldaprecord["sAMAccountName"] = "hpsgst_".$guestusername;
							$ldaprecord["UserAccountControl"] = "512"; 
						
			
						
							$r = ldap_add($ldap, $guestdn, $ldaprecord);
							
							
							
														
							
							ldap_close($ldap);
							
							
							// Add me to the guest group!
							
										// Connect us!
											$ldap = ldap_connect($adServer, 636);
											 ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
											ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
											// connect to active directory
											 $bind = @ldap_bind($ldap, $ldaprdn, $password);
										
										
	// Edit the group name for guest DN					
										
										$group_name = "";
									// Ex: $group_name = "CN=Guest,OU=Groups,DC=domain,DC=com";
									
									
										$group_info["member"] = $guestdn; // User's DN is added to group's 'member' array
										$gm = ldap_mod_add($ldap,$group_name,$group_info);
										
											
										
										ldap_close($ldap);
										
							
			
  
							
						
					
						
							
	/// End AD LDAP ---------------------------------
							

							
						
						
					
					
						
					?>
                    
                <div class="container"> 
                <div class="alert alert-success no-print" role="alert">
                Your guest has been successfully registered.  Please share or print the below information with your guest.  Your guest will be able to use the same username and password below to access the wireless as well as log on any district computer. 
				</div>
 
               <div class="alert alert-warning no-print" role="alert"> By registering your guest you assume full responsibility for their actions while using the wireless and/or district computer(s).<br />
  In addition, by using this account and connecting to the wireless network your guest agrees to accept and abide by the terms set forth in the Acceptable Use Policy.
               </div>
               
                
                 </div>   
                 <div class="container">
                 	<div class="form-group row">
                        <div class="col-xs-3">
                            <strong>Guest Name:</strong>
                        </div>
                        <div class="col-xs-8">
                        	 <?php echo $fname." ".$lname;?> 
                         </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-3">
                            <strong>Guest Location: </strong>
                        </div>
                        <div class="col-xs-8">
                         	<?php echo $location;?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-3">
                           <strong> Purpose of Access: </strong>
                        </div>
                        <div class="col-xs-8">
                         	<?php echo $_POST['purpose'];?> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-3">
                           <strong> Staff Sponsor: </strong>
                        </div>
                        <div class="col-xs-8">
                         	 <?php echo $sponsor;?> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-3">
                           <strong> Guest Username:</strong>
                        </div>
                        <div class="col-xs-8">
                         	 <?php echo $account;?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-3">
                           <strong> Guest Password: </strong>
                        </div>
                        <div class="col-xs-8">
                         	 <?php echo $pwdtxt;?>
                               
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-3">
                           <strong> Expiration: </strong>
                        </div>
                        <div class="col-xs-8">
                         	 This account will expire on: <?php echo $dt->format('m-d-Y H:i:s')?>
                               
                        </div>
                    </div>
                   
                   		 
                     <div class="alert alert-info" role="alert"> 
               		 If you have any questions, concerns, or need further assistance, please submit a helpdesk ticket or call the helpdesk line at extension 5511.
                	</div>
                    <button type="button" class="btn btn-primary no-print" onclick="printme()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</button>

            

						<script>
                        function printme() {
                            window.print();
                        }
                        </script>
              
                 </div>
				
				<?php

				}
// ---------------  Close if account DOESN'T exist				
				 else
				
// -------------------  If account DOES exist				
				 {
							 ?>
                             <div class="container"> 
                                 <div class="alert alert-danger no-print" role="alert">
                                 Error: This username already exists. Please try again with a different username.
                                 </div>
                             </div>
                             
				
			<?php	
// -------------  Close if account DOES exist	
				
				}						
				
			
				
// -------------  Close if form submitted		
			}
			
	
				 
	
			
			
		
// -------------  Close if registered passed			
	} else
// ------------- If registered wasn't passed
	 {
		// set vars for session variables used
	$access = $_SESSION['access'];
	$displayname = $_SESSION['displayname'];
	// We're in. 		
			


	
?>



				<div class="container" style="clear:both;">
					<h2><?php echo "Welcome, $displayname";?>
                    </h2>
                    
                    <div class="alert alert-warning" role="alert">
                    <p>Notification alert
                    </p></div>
                        
                </div><br />



<!------------  Registration Form -------------------->
				
                        
                        
                        
                        
					<div class="container">
                         <form action="index.php?registered" method="post">
                          <div class="form-group row">
                            <label for="fname" class="col-sm-2 form-control-label">Guest First Name:</label>
                            <div class="col-sm-10">
                             <input type="text" name="fname" placeholder="Guest First Name" required autofocus="autofocus" class="form-control"/>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label for="lname" class="col-sm-2 form-control-label">Guest Last Name:</label>
                            <div class="col-sm-10">
                              <input type="text" name="lname" placeholder="Guest Last Name" required autofocus="autofocus" class="form-control"/>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label for="purpose" class="col-sm-2 form-control-label">Purpose of Access:</label>
                            <div class="col-sm-10">
                              <input type="text" name="purpose" placeholder="Purpose of Access" required autofocus="autofocus" class="form-control"/>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label for="location" class="col-sm-2 form-control-label">Guest Location:</label>
                            <div class="col-sm-10">
                              <input type="text" name="location" placeholder="Guest Location" required autofocus="autofocus" class="form-control"/>
                               <small class="text-muted">Primary location for reference. Your guest is not limited to using their account in this location.</small>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label for="length" class="col-sm-2 form-control-label">Duration of Access:</label>
                            <div class="col-sm-10">
                              <select name="length" value='' class="form-control">
                                                    	  
                                                         
                                                           <option value="1 Hour">1 Hour</option>                                                       
                                                          <option value="1 Day">1 Day</option>
                                                          <option value="2 Days">2 Days</option>
                                                          <option value="3 Days">3 Days</option>
                                                          <option value="4 Days">4 Days</option>
                                                          <option value="5 Days">5 Days</option>
                                                          <?php if ($access == 2) {
															  echo '<option value="30 Days">1 Month</option>
															  <option value="60 Days">2 Months</option>
															  <option value="180 Days">6 Months</option>
															  <option value="365 Days">1 Year</option>
															  
															  ';
                                                        
														  }else {
															 echo '<option id="disabledInput"  value="" disabled>Please submit a helpdesk ticket for longer durations.</option>';
														  }
														  ?>
                                                          
                                                      
   							 </select>
                             <small class="text-muted">Your guest's account will automatically be disabled at the end of this requested duration.</small>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label for="guestusername" class="col-sm-2 form-control-label">Guest Username:</label>
                            <div class="col-sm-10">
                               <input type="input" name="guestusername" placeholder="Desired Guest Username" required autofocus="autofocus" class="form-control" maxlength="13"/>
                               <small class="text-muted">Maximum 13 characters.  All guest accounts will have a prefix of hpsgst_ added automatically.</small>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label for="location" class="col-sm-2 form-control-label">Guest Password:</label>
                            <div class="col-sm-10">
                             <input type="password" name="guestpassword" placeholder="Desired Guest Password" minlength="5" autofocus="autofocus" class="form-control" />
                               <small class="text-muted">Minimum 5 characters.</small>
                            </div>
                          </div>
                         
                         
                          <div class="form-group row">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button class="btn btn-primary" type="submit" >Register Guest</button>
                            </div>
                          </div>
                        </form>
                   </div>


<?php }



?>
</div>
  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="css/jquery.min.js"><\/script>')</script>
    <script src="css/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="css/ie10-viewport-bug-workaround.js"></script>
</body>