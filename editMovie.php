<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}

	if (isset($_GET['movie_ID'])) {

		$movie_id = mysqli_real_escape_string($connection, $_GET['movie_ID']);
		$query = "SELECT * FROM movie WHERE movie_ID = {$movie_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				//movie found
				$result = mysqli_fetch_assoc($result_set);
				$movie_Name = $result['movie_Name'];
				$startDate = $result['start_Date'];
				$endDate = $result['end_Date'];
			} else{
				//user not found
			}
		} else{
			//query unsucessful
		}
	}

	//Upon button click

	if (isset($_POST['submit'])) {
		


		$movie_ID = mysqli_real_escape_string($connection, $_POST['movie_ID']);

		if (empty(trim($_POST['movieTitle']))) {
			$errors[] = 'Movie title is required';
		}
		if (empty(trim($_POST['startDate']))) {
			$errors[] = 'Start date is required';
		}
		if (empty(trim($_POST['endDate']))) {
			$errors[] = 'End date is required';
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

		$query = "UPDATE movie SET movie_Name = '{$movieTitle}', start_Date = '{$startDate}', end_Date = '{$endDate}', img_Path = '{$imgPath}' WHERE movie_ID = {$movie_ID}";


		$result = mysqli_query($connection, $query);

		if ($result) {
			
			header('Location: addMovie.php');
		}
		else{

			$errors[] = $movie_ID;

			$errors[] = 'Failed to add record';
		}
	} }


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
				  		
				  		<form  action="editMovie.php" method="POST" enctype="multipart/form-data">

				  						<div class="form-group">
                                                    
                                                    <input type="hidden" name="movie_ID" class="form-control" id="movie_ID" aria-describedby="emailHelp" value= <?php echo $movie_id ?> >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                                                                
                                        <div class="form-group">
                                                    <label >Movie Title</label>
                                                    <input type="text" name="movieTitle" class="form-control" id="movieTitle"  placeholder="Enter movie title" value= '<?php echo $movie_Name; ?>' required>
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>
                                
                                        <div class="form-group">
                                            <label >Start Date</label>
                                            <input type="date" name="startDate" class="form-control" id="startDate" placeholder="Enter Start Date" value= '<?php echo $startDate ?>' required>
                                            <p id="p_error" style="color: red; font-size: small;"></p>

                                         </div>

                                         <div class="form-group">
                                            <label >End Date</label>
                                            <input type="date" name="endDate" class="form-control" id="endDate" placeholder="Enter End Date"  value= '<?php echo $endDate ?>' required>
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>

                                         <div class="form-group">
                                            <label >Movie Poster</label>
                                            <input type="file" name="moviePoster" class="form-control" id="moviePoster" required>
                                            <p id="p_error" style="color: red; font-size: small;"></p>
                                         </div>

<!--                                          <?php 
 											//echo '<img src = "' . $upload_to . $file_name . '" style = //"height:10%">';
                                          ?> -->


                                         <input type="submit" id="submit" name="submit" value="Update Movie" class="btn btn-primary">
                                         

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