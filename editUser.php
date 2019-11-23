<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}
?>	

<?php 

	$errors = array();



	if (isset($_GET['userID'])) {
		$user_id = mysqli_real_escape_string($connection, $_GET['userID']);
		$query = "SELECT * FROM users WHERE userID = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				//user found
				$result = mysqli_fetch_assoc($result_set);
				$email = $result['email'];


			} else{
				//user not found
			}
		} else{
			//query unsucessful
		}
	}

	if (isset($_POST['submit'])) {
		
		$user_id = mysqli_real_escape_string($connection, $_POST['userID']);

		if (empty(trim($_POST['email']))) {
			$errors[] = 'Email is required';
		}
		if (empty(trim($_POST['password']))) {
			$errors[] = 'Password is required';
		}
		if (empty(trim($_POST['password2']))) {
			$errors[] = 'Confirm password field is required';
		}
		if (trim($_POST['password2']) != trim($_POST['password'])) {
			$errors[] = 'Passwords do not match';
		}

		//checking max length

	$max_len_fields = array('email' => 200, 'password' => 200, 'password2' => 200 );

	foreach ($max_len_fields as $field => $max_len) {
		if (strlen(trim($_POST[$field])) > $max_len) {
			
			$errors[] = $field . 'must be less than ' . $max_len . ' characters';

		}
	}

	//checking if email address exists

	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$query  = "SELECT * FROM users WHERE email = '{$email}' AND userID != {$user_id } LIMIT 1";

	$result_set = mysqli_query($connection, $query);

	if ($result_set) {
		if (mysqli_num_rows($result_set) == 1) {
			$errors[] = 'Email already exists';
		}
	}

	if (empty($errors)) {
		
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$password = mysqli_real_escape_string($connection, $_POST['password2']);
		$user_id = mysqli_real_escape_string($connection, $_POST['userID']);


		$hashed_password = sha1($password);
		$userType = "admin";

		
		$query = "UPDATE users SET email = '{$email}', password = '{$hashed_password}' WHERE userID = {$user_id}";


		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: userManagement.php');
		}
		else{
			$errors[] = 'Failed to update record';

			$errors[] = $email;
		}
	}

	}

	

?>



<!DOCTYPE html>
<html>
<head>
	<title>MyTickets | Register</title>

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

		.errmsg{
			color: red;
			text-align: left;
			font-size: 12px;
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
			        <a class="nav-link text-light" href="#">Home <span class="sr-only">(current)</span></a>
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
				  <div class="card-header cardheader_override">Register Admin</div>
				  <div class="card-body">
				  	
				  	<div class="text-center">
				  		<img class="card-img-top mx-auto" style="width:50%;" src="./images/login.png" alt="Login Icon" >

				  		<br>

				  		<?php 

				  			if (!empty($errors)) {
				  				echo '<div class = "errmsg">';
				  				echo '<b>There were error(s) on your form,</b><br>';
				  				foreach ($errors as $key => $error) {
				  					echo $error . '<br>';

				  				}
				  				echo '</div>';
				  			}

				  		?>

				  		<form  action="editUser.php" method="POST">

				  						<div class="form-group">
                                                    
                                                    <input type="hidden" name="userID" class="form-control" id="email" aria-describedby="emailHelp" value= <?php echo $user_id ?> >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                                                                
                                        <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value= <?php echo $email ?> >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                

                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" >
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>

                                         <div class="form-group">
                                            <label for="password">Confirm Password</label>
                                            <input type="password" name="password2" class="form-control" id="password" placeholder="Password" >
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>


                                         <input type="submit" id="submit" name="submit" value="Update" class="btn btn-primary"></input>
                                         <span><a href="login.php"><i>&nbsp;&nbsp;&nbsp;</i>Login</a></span>

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