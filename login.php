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

include("config.php");



// check to see if login form has been submitted
if(isset($_POST['username'])){
	
	
	// Log Variables 
	$user = $_POST['username'];
	$type = "Login";
	
	
	
	// run information through authenticator
	if(authenticate($_POST['username'],$_POST['password']))
	{
		
		
		
		
		
		
		
		header("Location: ".$url."index.php");
		die();
	} else {
		// authentication failed
		$error = 1;
	}
}
include ('navigation.php');
?>
<body>
<div class="container">
<?php
// output error to user
if(isset($error)) echo '<div class="alert alert-danger">Login failed: Incorrect user name, password, or rights</div>';

// output logout success
if(isset($_GET['out'])) echo "Logout successful";
?>

<div class="container" style="clear:both;">
					<h2>Welcome
                    </h2>
                    
                    <div class="alert alert-info" role="alert">
                    <p>Please sign in using your computer credentials.
                    </p></div>
                        
                </div><br />

<form action="login.php" method="post" class="form-signin">
	<input type="text" name="username" placeholder="Username" class="form-control" autofocus/>
	<input type="password" name="password" placeholder="Password" class="form-control"/>
	<button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
</form>
</div>
</body>