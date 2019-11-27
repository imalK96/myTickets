<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}
?>	

<?php 

	$errors = array();

	$movie_list = '';

	//getting list of users
	$query = "SELECT * FROM movie";

	$movies = mysqli_query($connection, $query);

	if ($movies) {
		while ($movie = mysqli_fetch_assoc($movies)) {
			$movie_list .= "<tr>";
			//$movie_list .= "<td>{$movie['movie_ID']}</td>";
			$movie_list .= "<td>{$movie['movie_Name']}</td>";
			$movie_list .= "<td>{$movie['start_Date']}</td>";
			$movie_list .= "<td>{$movie['end_Date']}</td>";
			$movie_list .= "<td><img class = 'tableImg' src = {$movie['img_Path']}></td>";
			
			$movie_list .= "<td><button class = 'btn btn-light'><a class = 'disableBtnLink' href = \"editMovie.php?movie_ID={$movie['movie_ID']}\">Edit</a></></td>";

			$movie_list .= "<td><button class = 'btn btn-light'><a class = 'disableBtnLink' href = \"deleteUser.php?movie_ID={$movie['movie_ID']}\">Remove</a></></td>";
			$movie_list .= "<tr>";
		}
	}
	else{
		echo "DB query failed!";
	}

	if (isset($_POST['submit'])) {
		

		if (empty(trim($_POST['movieTitle']))) {
			$errors[] = 'Movie title is required';
		}
		if (empty(trim($_POST['startDate']))) {
			$errors[] = 'Starting date is required';
		}
		if (empty(trim($_POST['endDate']))) {
			$errors[] = 'Ending date is required';
		}


		
	if (empty($errors)) {
		
		$movieTitle = mysqli_real_escape_string($connection, $_POST['movieTitle']);
		$startDate = mysqli_real_escape_string($connection, $_POST['startDate']);
		$endDate = mysqli_real_escape_string($connection, $_POST['endDate']);

		$file_name = $_FILES['moviePoster']['name'];
		$file_type = $_FILES['moviePoster']['type'];
		$file_size = $_FILES['moviePoster']['size'];
		$temp_name = $_FILES['moviePoster']['tmp_name'];

		$upload_to = 'images/';

		//print_r($_FILES);

		$file_uploaded = move_uploaded_file($temp_name, $upload_to . $file_name);
		
		$imgPath = $upload_to . $file_name;

		$query = "INSERT INTO movie ( movie_Name, start_Date, end_Date, img_Path ) VALUES ('{$movieTitle}', '{$startDate}', '{$endDate}', '{$imgPath}')";


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
	<title>MyTickets | Register</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<style type="text/css">
		
		body{
			background-color:white;
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
		.tableBody{
        background-color: #255C99;
        color:white;
        font-family:Arial, Helevetica, sans-serif;
        font-size:14px;
        line-height:1.6em;
        margin-top: 30px;
        padding: 30px;
        
        }

        .adminBody{
        	background-color: lightgray;
        color:#071229;
        font-family:Arial, Helevetica, sans-serif;
        font-size:16px;
        line-height:1.6em;
        }

        .disableBtnLink{
        	text-decoration: none;
        	color: black;
        }
        .btnprimaryoveride{
        	padding: 0px;
        	margin-bottom: 20px;	
        }

        .btn{
        	padding: 3px;
        }

        .tableImg{
        	width: 50px;
        	height: 60px;
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

	  		<div class="col-sm-4" style="margin-left: 20px;">
			  	<div class="card login_cardoverride">
				  <div class="card-header cardheader_override">Add New Movie</div>
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
				  <div class="card-footer cardheader_override"></div>
				</div>
			</div>

			<div class="col" style="margin-right: 20px; ">
								  		
				  		<div class="container tableBody" style="border-radius: 10px;">
							<span class="input-group">
								<h3>Movie Management</h3>
						  		
						  	</span>
						  
						      
						  <table class="table table-hover">
						    <thead>
						      <tr>
						      	<th>Movie Title</th>
						        <th>Start Date</th>
						        <th>End Date</th>
						        <th>Poster</th>
						        
						        <th>Edit Details</th>
						        <th>Remove Movie</th>
						        
						      </tr>
						    </thead>
						    <tbody>
						      <?php echo $movie_list; ?>
						    </tbody>
						  </table>
						</div>

				  	</div>

			
	  
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