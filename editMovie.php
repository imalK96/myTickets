<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}

	$user_list = '';

	//getting list of users
	$query = "SELECT * FROM users";

	$users = mysqli_query($connection, $query);

	if ($users) {
		while ($user = mysqli_fetch_assoc($users)) {
			$user_list .= "<tr>";
			$user_list .= "<td>{$user['userID']}</td>";
			$user_list .= "<td>{$user['email']}</td>";
			$user_list .= "<td>{$user['type']}</td>";
			
			$user_list .= "<td><button class = 'btn btn-warning'><a class = 'disableBtnLink' href = \"editUser.php?userID={$user['userID']}\">Edit</a></></td>";

			$user_list .= "<td><button class = 'btn btn-warning'><a class = 'disableBtnLink' href = \"deleteUser.php?userID={$user['userID']}\">Disable</a></></td>";
			$user_list .= "<tr>";
		}
	}
	else{
		echo "DB query failed!";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>MyTickets! | User Management</title>

	<style type="text/css">

	.card-header2{
			background-color:#255C99;
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
<body class="adminBody">

	<?php include 'header.php';?>

	<div class="row">

	  		
			<div class="col-sm-4">

			</div>

			<div class="col-sm-4" style="margin-left: 20px;">
			  	<div class="card login_cardoverride">
				  <div class="card-header card-header2" style="background-color:#255C99;">Add New Movie</div>
				  <div class="card-body">
				  	
				  	<div class="text-center">
				  		<img class="card-img-top mx-auto" style="width:25%; margin-bottom: 10px;" src="./images/film.svg" alt="Login Icon" >

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
				  		
				  		<form  action="addMovie.php" method="POST" enctype="multipart/form-data">
                                                                                
                                        <div class="form-group">
                                                    <label >Movie Title</label>
                                                    <input type="text" name="movieTitle" class="form-control" id="movieTitle"  placeholder="Enter movie title" >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                

                                        <div class="form-group">
                                            <label >Start Date</label>
                                            <input type="date" name="startDate" class="form-control" id="startDate" placeholder="Enter Start Date" >
                                            <p id="p_error" style="color: red; font-size: small;"></p>

                                         </div>

                                         <div class="form-group">
                                            <label >End Date</label>
                                            <input type="date" name="endDate" class="form-control" id="endDate" placeholder="Enter End Date" >
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>

                                         <div class="form-group">
                                            <label >Movie Poster</label>
                                            <input type="file" name="moviePoster" class="form-control" id="moviePoster">
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>

<!--                                          <?php 
 											//echo '<img src = "' . $upload_to . $file_name . '" style = //"height:10%">';
                                          ?> -->


                                         <input type="submit" id="submit" name="submit" value="Add Movie" class="btn btn-primary">
                                         

                                </form>
				  	</div>

				  	
				  </div> 
				  <div class="card-footer card-header2" style="background-color:#255C99;"></div>
				</div>
			</div>

			<div class="col-sm-4">

			</div>

		</div>

			<div class="col-sm-3">

			</div>


	<?php include 'footer.html';?>

</body>
</html>