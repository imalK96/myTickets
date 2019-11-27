<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>

<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}
?>	

<?php

	$showtime_list = '';

	$movie_list = '';

	$assignment_list = '';

	$showtime_dropdown = '';

	//getting list of users
	$query = "SELECT * FROM showtime";

	$query2 = "SELECT * FROM movie";

	$query3 = "SELECT * FROM movie m, showtime s, movie_showtime x WHERE x.movie_ID = m.movie_ID AND x.show_ID = s.show_ID ";

	$showtimes = mysqli_query($connection, $query);

	$movie_showtimes = mysqli_query($connection, $query3);

	$movies = mysqli_query($connection, $query2);
	//showtime table
	if ($showtimes) {
		//creating showtime dropdown
		$showtime_dropdown .= "<select class = \"dropdown\" name = 'showtime_dropdown'>";

		while ($showtime = mysqli_fetch_assoc($showtimes)) {
			//creating table
			$showtime_list .= "<tr>";
			//$showtime_list .= "<td>{$movie['movie_ID']}</td>";
			$showtime_list .= "<td>{$showtime['showtime']}</td>";
						
			$showtime_list .= "<td><button class = 'btn btn-light'><a class = 'disableBtnLink' href = \"showtime.php?movie_ID={$showtime['show_ID']}\">Edit</a></></td>";

			$showtime_list .= "<td><button class = 'btn btn-light'><a class = 'disableBtnLink' href = \"showtime.php?movie_ID={$showtime['show_ID']}\">Remove</a></></td>";
			$showtime_list .= "<tr>";

			//adding to showtime dropdown
			$showtime_dropdown .= "<option value = '{$showtime['show_ID']}'>{$showtime['showtime']}</option>";

		}
	}

//assignment table
	if ($movie_showtimes) {
		
		while ($movie_showtime = mysqli_fetch_assoc($movie_showtimes)) {
			//creating table
			$assignment_list .= "<tr>";
			//$assignment_list .= "<td>{$movie['movie_ID']}</td>";
			$assignment_list .= "<td>{$movie_showtime['movie_Name']}</td>";

			$assignment_list .= "<td>{$movie_showtime['showtime']}</td>";
						
			$assignment_list .= "<td><button class = 'btn btn-light'><a onclick='asd(2)' class = 'disableBtnLink' href = \"showtime.php?movie_ID={$movie_showtime['movie_ID']}?show_ID={$movie_showtime['show_ID']}\">Edit</a></></td>";

			$assignment_list .= "<td><button class = 'btn btn-light'><a class = 'disableBtnLink' href = \"showtime.php?movie_ID={$movie_showtime['movie_ID']}?show_ID={$movie_showtime['show_ID']}\">Remove</a></></td>";
			$assignment_list .= "<tr>";

			
		}
	}



//movie dropdown list
	if ($movies) {
		$movie_list .= "<select class = \"dropdown\" name = 'movie_list'>";
		while ($movie = mysqli_fetch_assoc($movies)) {
			$movie_list .= "<option value = '{$movie['movie_ID']}'>{$movie['movie_Name']}</option>";
		}
		$movie_list .= "</select>";
	}


	else{
		echo "DB query failed!";
	}


	if (isset($_POST['submit'])) {
		

		if (empty(trim($_POST['showtime']))) {
			$errors[] = 'Showtime is required';
		}
	
	if (empty($errors)) {
		
		$showtime = mysqli_real_escape_string($connection, $_POST['showtime']);
		
		
		$query = "INSERT INTO showtime ( showtime ) VALUES ('{$showtime}')";

		$result = mysqli_query($connection, $query);

		if ($result) {
			//Change this
			//echo "Added successfully";
		}
		else{

			$errors[] = 'Failed to add record';
		}
	}

	}
	if (isset($_POST['assign'])) {
		
	
	if (empty($errors)) {
		
		$showtime_id = mysqli_real_escape_string($connection, $_POST['showtime_dropdown']);
		$movie_id = mysqli_real_escape_string($connection, $_POST['movie_list']);
		
		
		$query = "INSERT INTO movie_showtime ( movie_ID, show_ID ) VALUES ('{$movie_id}','{$showtime_id}')";

		$result = mysqli_query($connection, $query);

		if ($result) {
			//Change this
			//echo "Added successfully";
		}
		else{

			$errors[] = 'Failed to add record';
		}
	}

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
			width: 70%;
			margin-left: 20px;
		}

		.errmsg{
			color: red;
			text-align: left;
			font-size: 12px;
		}

		.tableBody{
        background-color: #255C99;
        color:white;
        font-family:Arial, Helevetica, sans-serif;
        font-size:14px;
        line-height:1.6em;
        margin-top: 30px;
        padding: 30px;
        
        }

        select {
        	padding: 7px;
        	width: 80%;

        }

        label{
        	margin-top: 10px;
        }

		
		 
	</style>
		
</head>
<body class="adminBody" style="background-color: #fff">

	<?php include 'header.php';?>

	<div class="row">

	  		
			<div class="col" style="margin-left: 10px;">

				<div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 20px; margin-left: 20px;">

					<button class="btn btn-primary" type="button" onclick="asd(1)" id="insert" value="Add new Product">Add Showtime</button>

					<button class="btn btn-info" type="button" onclick="asd(2)" id="update" value="Update Product">Assign Showtime</button>



					<button class="btn btn-primary" type="button" onclick="asd(0)" id="update" value="Hide Form">Hide Form</button>
				</div>	

					<!-- Add showtime form -->

				<div id="add" class="card login_cardoverride">

				  <div class="card-header card-header2" style="background-color:#255C99;">Add New Showtime</div>
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
				  		
				  		<form  action="showtime.php" method="POST" enctype="multipart/form-data">
	                                                                            
                                        <div class="form-group">
                                                    <label >Showtime</label>
                                                    <input type="time" name="showtime" class="form-control" id="showtime"  placeholder="Enter showtime" required>
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                  
                                         <input type="submit" id="submit" name="submit" value="Add Showtime" class="btn btn-primary">
                        </form>

				  	</div>

				  	
				  </div> 
				  <div class="card-footer card-header2" style="background-color:#255C99;"></div>
				</div>

				<!-- Assign showtime form -->

				<div id="assign" class="card login_cardoverride" >



				  <div class="card-header card-header2" style="background-color:#255C99;">Assign Showtime</div>
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
				  		
				  		<form  action="showtime.php" method="POST" enctype="multipart/form-data">
	                                                                            
                                        <div class="form-group">
                                        	<label >Select Movie</label>
                                        	<?php echo $movie_list; ?>

                                            <label >Assign Showtime</label><br>

                                            <?php echo $showtime_dropdown; ?>


                                           <input type="hidden" name="showtime" class="form-control" id="showtime"  placeholder="Enter showtime" required>
                                            

                                        </div>
                                  
                                         <input type="submit" id="assign" name="assign" value="Assign Showtime" class="btn btn-primary">
                        </form>



				  	</div>

				  	
				  </div> 
				  <div class="card-footer card-header2" style="background-color:#255C99;"></div>
				</div>

				<!-- Edit assignments -->

				<div id="edit_assign" class="card login_cardoverride" >



				  <div class="card-header card-header2" style="background-color:#255C99;">Assign Showtime</div>
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
				  		
				  		<form  action="showtime.php" method="POST" enctype="multipart/form-data">
	                                                                            
                                        <div class="form-group">
                                        	<label >Select Movie</label>
                                        	<?php echo $movie_list; ?>

                                            <label >Assign Showtime</label><br>

                                            <?php echo $showtime_dropdown; ?>


                                           <input type="hidden" name="showtime" class="form-control" id="showtime"  placeholder="Enter showtime" required>
                                            

                                        </div>
                                  
                                         <input type="submit" id="assign" name="assign" value="Assign Showtime" class="btn btn-primary">
                        </form>

                        

				  	</div>

				  	
				  </div> 
				  <div class="card-footer card-header2" style="background-color:#255C99;"></div>
				</div>

			</div>

			<div class="col" style="margin-right:20px; margin-top: 60px;">

				<div class="container tableBody" style="border-radius: 10px;">
							<span class="input-group">
								<h3>Showtimes</h3>
						  		
						  	</span>
						  
						      
						  <table class="table table-hover">
						    <thead>
						      <tr>
						      	<th>Showtime</th>
						        					        
						        <th>Edit Showtime</th>
						        <th>Remove Showtime</th>
						        
						      </tr>
						    </thead>
						    <tbody>
						      <?php echo $showtime_list; ?>
						    </tbody>
						  </table>
						</div>

						<div class="container tableBody" style="border-radius: 10px; background-color: #778ADE">
							<span class="input-group">
								<h3>Current Assignments</h3>
						  		
						  	</span>
						  
						      
						  <table class="table table-hover">
						    <thead>
						      <tr>
						      	<th>Movie Title</th>
						      	<th>Showtime</th>
						        					        
						        <th>Edit </th>
						        <th>Remove </th>
						        
						      </tr>
						    </thead>
						    <tbody>
						      <?php echo $assignment_list; ?>
						    </tbody>
						  </table>
						</div>
			  	
			</div>

			


			
		</div>

			

	<?php include 'footer.html';?>

</body>
</html>

<script type="text/javascript">

		  window.onload = function() {

		    document.getElementById("add").style.display = "none";
		    document.getElementById("assign").style.display = "none";
		    document.getElementById("edit_assign").style.display = "none";

		  };

		  function asd(a) {
		  
		    if (a == 1) {
		      document.getElementById("add").style.display = "block";
		      document.getElementById("assign").style.display = "none";
		    }
		    else if (a == 2) {
		      document.getElementById("assign").style.display = "block";
		      document.getElementById("add").style.display = "none";
		    }
		     else {
		      document.getElementById("add").style.display = "none";
		      document.getElementById("assign").style.display = "none";
		    }
		      
		  }
		</script>
