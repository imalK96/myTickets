<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}
?>	

<?php

	$errors = array();
	
	

	if (isset($_POST['emailSubmit'])) {

		
		if (empty(trim($_POST['email']))) {
			$errors[] = 'Email is required';
		}

		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query  = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Account with given email already exists';
			}
		}

		if (empty($errors)) {

			$email = mysqli_real_escape_string($connection, $_POST['email']);
			$user_id = $_SESSION['userID'];

			$query = "UPDATE users SET email = '{$email}' WHERE userID = {$user_id}";


			$result = mysqli_query($connection, $query);

			if ($result) {
				header('Location: logout.php?email_updated');
			}
			else{
				$errors[] = 'Failed to update record';

				
			}

			} }

			if (isset($_POST['pwSubmit'])) {

				if (empty(trim($_POST['password1']))) {
					$errors[] = 'Password is required';
				}
				if (empty(trim($_POST['password2']))) {
					$errors[] = 'Confirm password field is required';
				}
				if (trim($_POST['password2']) != trim($_POST['password1'])) {
					$errors[] = 'Passwords do not match';
				}

				if (empty($errors)) {
					$password = mysqli_real_escape_string($connection, $_POST['password2']);
					$user_id = $_SESSION['userID'];

					$hashed_password = sha1($password);

					$query = "UPDATE users SET password = '{$hashed_password}' WHERE userID = {$user_id}";


					$result = mysqli_query($connection, $query);

					if ($result) {
						header('Location: logout.php?password_changed');
					}
					else{
						$errors[] = 'Failed to update record';

						
					}

			}
		}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	 .adminBody{
        	background-color: lightgray;
        color:#071229;
        font-family:Arial, Helevetica, sans-serif;
        font-size:16px;
        line-height:1.6em;
        }

         body{
        background-color: #e0e0e0;
      }      
      .card{
        margin-top: 20px;
        
      }
      .card_header{
        background-color: red;
        color: blue;
      }
      .card-footer{
        background-color: #071229;
       
      }
      .card_body_override{
        background: red;
      }
      .card{
        background: #fbf9ff;
      }

</style>
</head>
<body class="adminBody">

	<?php include 'header.php';?>


	<!--My Account code begins here-->
	<div class="row">
		<div class="col-sm-2"></div>
	 	<div class="col-sm-8">
	 		<div class="card" style="margin: 40px;">
			  <div class="card-header text-white" style="background-color: #071229;">
			    Profile
			  </div>
			  <div class="card-body" style="background-color: #fff;">
			   
			  					
					<button class="btn btn-primary" type="button" onclick="asd(1)" id="insert" value="Add new Product">Edit Email</button>

					<button class="btn btn-primary" type="button" onclick="asd(2)" id="update" value="Update Product">Change Password</button>

					<button class="btn btn-primary" type="button" onclick="asd(0)" id="update" value="Hide Form">Hide Form</button>

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

					<form id="asd" action="profile.php" method="POST" style="margin-top: 30px;">
					   
						  <div class="form-group">
						    <label for="exampleInputEmail1">New Email address</label>
						    <input name = "email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
						    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
						  </div>
						  
						 
						  <input type="submit" name="emailSubmit" class="btn btn-info"> 
				
					
					</form>

					<form id="pw" action="profile.php" method="POST" style="margin-top: 30px;">
					  <div class="form-group">
						    <label for="exampleInputPassword1">New Password</label>
						    <input name="password1" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter New Password">
						    
						</div> 

						<div class="form-group">
						    <label for="exampleInputPassword1">Confirm Password</label>
						    <input name="password2" type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirm New Password">
						    
						</div> 

						<input type="submit" name="pwSubmit" class="btn btn-info"> 

						
					</form>



		
			    
			  </div>
			  <div class="card-footer text-muted" style="background-color: #071229;">
			   
			  </div>
			</div>
	 	</div>
	 	<div class="col-sm-2"></div>
	 	
	</div> 	
	

    
	<?php include 'footer.html';?>

</body>


<script type="text/javascript">

		  window.onload = function() {

		    document.getElementById("asd").style.display = "none";
		    document.getElementById("pw").style.display = "none";

		  };

		  function asd(a) {
		  
		    if (a == 1) {
		      document.getElementById("asd").style.display = "block";
		      document.getElementById("pw").style.display = "none";
		    }
		    else if (a == 2) {
		      document.getElementById("pw").style.display = "block";
		      document.getElementById("asd").style.display = "none";
		    }
		     else {
		      document.getElementById("asd").style.display = "none";
		      document.getElementById("pw").style.display = "none";
		    }
		      
		  }
		</script>

</html>


