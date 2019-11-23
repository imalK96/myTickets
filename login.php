<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php

	$errors = array();
//check for form submission

if (isset($_POST['submit'])) {

//check if username and password has been entered
	if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1) {
		$errors[] = 'Username is invalid';
	}

	if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1) {
		$errors[] = 'Password is invalid';
	}

//check errors
if (empty($errors)) {
	//save username and pw into variables

	$email = mysqli_real_escape_string($connection, $_POST['email']) ;
	$password = mysqli_real_escape_string($connection, $_POST['password']) ;

	$hashed_password = sha1($password);

// prepare db query
	$query = "SELECT * FROM users 
				WHERE email = '{$email}' AND password = '{$hashed_password}'";

	$result_set = mysqli_query($connection, $query);	
	
	if($result_set){
		//check if user is valid
		if (mysqli_num_rows($result_set) == 1) {

			$user = mysqli_fetch_assoc($result_set);

			$_SESSION['userID'] = $user['userID'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['type'] = $user['type'];


			//redirect to index.php
			header('Location: index.php?login_successful');
		}else{
			$errors[] = 'Invalid username / password';
		}

	}else{
		$errors[] = 'Database query failed';
	}		
}}
	
	

	

	

?>

<!DOCTYPE html>
<html>
<head>
	<title>MyTickets | Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<style type="text/css">
		
		body{
			background-color:black;
			color:#555;
			font-family:Arial, Helevetica, sans-serif;
			font-size:16px;
			margin-bottom: 120px;
			
		}

		.header-img{
			margin-top: 0;
			padding: 0;
		}

		
		.footer {
			
			background-color:#071229;
        	color: white;
        	margin-bottom: 0px;
        	font-size: 12px;
        	text-align: center;
        	padding-top: 5px;
        	padding-bottom: 5px;
        	
        }
		
		.navbar_override{
			background-color:#071229;
			color: white;
		}

		.cardheader_override{
			background-color:#071229;
			text-align: center;
			color: white;
		}

		.login_cardoverride{
			margin-top: 30px;
		}

		.error{
			color: red;
			padding: 10px;
		}

		

	</style>

</head>
<body>
	<header>
			<!-- A grey horizontal navbar that becomes vertical on small screens-->
			<nav class="navbar navbar-expand-sm navbar_override">
			  <a class="navbar-brand" href="#">
    			<img src="./Images/logo.png" width="120" height="30" alt="">
  			  </a>
			    <ul class="navbar-nav">
			      <li class="nav-item active">
			        <a class="nav-link text-light" href="index.php">Home <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link text-light" href="#">Book Now</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link text-light" href="#">Showtimes</a>
			      </li>
			      			     
			    </ul>

			    			  
			</nav>
		</header>

		<div class="row">

	  		<div class="col"></div>

	  		<div class="col">
			  	<div class="card login_cardoverride">
				  <div class="card-header cardheader_override">Login</div>
				  <div class="card-body">
				  	
				  	<div class="text-center">
				  		<img class="card-img-top mx-auto" style="width:50%;" src="./images/login.png" alt="Login Icon" >

				  		<form  action="login.php" method="POST">
				  						<?php
				  							if (isset($errors) && !empty($errors)) {
				  								
				  								echo '<p class = "error">Invalid username/password</p>';	
				  							}
				  						 ?>
				  						
                                                                                
                                        <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input type="text" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                

                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" >
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>


                                         <input type="submit" id="submit" name="submit" value="Login" class="btn btn-primary"></input>
                                         <span><a href="register.php"><i>&nbsp;&nbsp;&nbsp;</i>Register</a></span>

                                </form>
				  	</div>


				  </div>
				  <div class="card-footer cardheader_override"></div>
				</div>
			</div>

			<div class="col"></div>
	  
		</div>

		

		<footer class="fixed-bottom footer container-fluid">
			 			 	
  			  <div class="row ">
  			  	<div class="col-md-3">
  			  		<img src="./Images/logo.png" width="60%">
  			  	</div>
				  <div class="col-md-3">
				  	<br>
				  	<p>© 2018 MyTickets.lk All Rights Reserved.</p>
				  
				  </div>
				  <div class="col-md-3">
				  		<b>Contacts Us</b><br/>
		                info@mymovies.lk<br/>
				  </div>
				  
				  <div class="col-md-3">
				  	<b>Follow us on</b><br/>
                    <a href="https://www.facebook.com/"  target="_blank"><img src="./Images/facebook.png" width="7%"></a>
                    <a href="https://www.instagram.com/?hl=en"  target="_blank"><img src="./Images/instagram.png" width="7%"></a>
                    <a href="https://twitter.com/?lang=en"  target="_blank"><img src="./Images/twitter.png" width="7%" ></a>
				  </div>
			</div>
			

		</footer>
</body>
</html>

<?php mysqli_close($connection); ?>