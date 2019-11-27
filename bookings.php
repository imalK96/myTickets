<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}

	if (isset($_GET['movie_ID'])) {

		$showtime_dropdown = '';

		$movie_id = mysqli_real_escape_string($connection, $_GET['movie_ID']);
		$query = "SELECT * FROM movie WHERE movie_ID = {$movie_id} LIMIT 1";

		$query2 = "SELECT * FROM movie_showtime ms, showtime s WHERE movie_ID = {$movie_id} AND ms.show_ID = s.show_ID";

		$result_set = mysqli_query($connection, $query);
		$showtime_result_set = mysqli_query($connection, $query2);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				//movie found
				$result = mysqli_fetch_assoc($result_set);
				$movie_Name = $result['movie_Name'];
				$startDate = $result['start_Date'];
				$endDate = $result['end_Date'];
			} else{
				//movie not found
			}
		} else{
			//query unsucessful
		}

		if ($showtime_result_set) {
			//creating showtime dropdown
			$showtime_dropdown .= "<select class = \"dropdown\" name = 'showtime_dropdown'>";

			while ($showtime = mysqli_fetch_assoc($showtime_result_set)) {
				$showtime_dropdown .= "<option value = '{$showtime['show_ID']}'>{$showtime['showtime']}</option>";
			}
		}


	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<title>MyTickets! | Bookings</title>

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

	<div class="container-fluid row">

	  	
			<div class="col" style="margin-left: 10px;">
			  	<div class="card login_cardoverride">
				  <div class="card-header card-header2" style="background-color:#255C99;">Bookings</div>
				  <div class="card-body">
				  	
				  	<div class="text-center">
				  		

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
				  		
				  		<form  action="reservations.php" method="GET" enctype="multipart/form-data">

		  						         <div class="form-group">
                                                   
                                                    <input type="hidden" name="movie_ID" class="form-control" id="movie_ID" aria-describedby="emailHelp" value= '<?php echo $movie_id; ?>'  >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>               
	                          
	                                    <div class="form-group">
                                                    <label for="email">Movie title</label>
                                                    <input type="readonly" name="movie_Name" class="form-control" id="movie_Name" aria-describedby="emailHelp" value= '<?php echo $movie_Name; ?>'  >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>

                                        <div class="form-group">
                                                    <label >Movie title</label>
                                                    <input type="date" name="date" class="form-control" id="date" aria-describedby="emailHelp"  >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                                        </div>

	                                         <label for="email">Select showtime</label>
	                                        <?php echo $showtime_dropdown; ?>
	                                        <p id="e_error" style="color: red; font-size: small;"></p>
	                          
	                            
	                             <input type="submit" id="submit" name="submit" value="Proceed" class="btn btn-primary">
                                         

                                </form>
				  	</div>

				  	
				  </div> 
				  <div class="card-footer card-header2" style="background-color:#255C99;"></div>
				</div>
			</div>

			

		</div>

			


	<?php include 'footer.html';?>

</body>
</html>