<!--

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

-->

<head>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    

    <title>Guest Registration</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="css/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


	<?php 
	if (strpos($_SERVER['SCRIPT_NAME'], 'login.php') == true){
		?>
		<link rel="stylesheet" href="css/signin.css">
        
    <?php }?>
</head>
<?php

if(empty($_SESSION['user'])){ } else {
	?>
<body>    


    

    
    		<nav class="navbar navbar-fixed-top navbar-inverse no-print" style="background-color: #0275D8;">
              <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                   <a class="navbar-brand" href="index.php"> Guest Registration</a>
                </div>
            
               
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                   
                   <li><a href="#"></a></li>
            	   <li><a href="#"></a></li>
                    
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                     <li><a href="<?php echo $url; ?>index.php?logout">Logout</a></li>
                    
                  </ul>
                </div>
              </div>
            </nav>
    
    
  
    
    
 
        

<?php }?>

        