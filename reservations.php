<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}

	if (isset($_GET['movie_ID'])) {

		$movie_ID = mysqli_real_escape_string($connection, $_GET['movie_ID']);
		$movie_Name = mysqli_real_escape_string($connection, $_GET['movie_Name']);
		$movie_showtime = mysqli_real_escape_string($connection, $_GET['showtime_dropdown']);
		$movie_date = mysqli_real_escape_string($connection, $_GET['date']);

		
		$seats_query = "SELECT * FROM seats WHERE seatName NOT IN (SELECT seatID FROM reservations WHERE date = '$movie_date' AND showtime = $movie_showtime)";

		$seat_resultset = mysqli_query($connection, $seats_query);

		$num_seats = mysqli_num_rows($seat_resultset);

		
		  
		

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
				  		
				  		<form  action="bookingHandler.php" method="POST" enctype="multipart/form-data">

				  			<div class="form-group">
                                                    <label for="email">Movie title</label>
                                                    <input type="text" readonly name="movie_Name" class="form-control" id="movie_Name" aria-describedby="emailHelp" value= '<?php echo $movie_Name; ?>'  >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                            </div>

                            <div class="form-group">
                                                   
                                                    <input type="hidden" name="showtime" class="form-control" id="movie_Name" aria-describedby="emailHelp" value= '<?php echo $movie_showtime; ?>'  >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                            </div>

                            <div class="form-group">
                                                   <label for="email">Date</label>
                                                    <input type="date" readonly="readonly" name="date" class="form-control" id="movie_Name" aria-describedby="emailHelp" value= '<?php echo $movie_date; ?>'  >
                                                    <p id="e_error" style="color: red; font-size: small;"></p>
                            </div>

				  			<?php while ($seat = mysqli_fetch_assoc($seat_resultset)) {
				  				
				  			?>

		  						<div class="form-check form-check-inline">

		  						  <input name = "seats[]" value = <?php echo $seat['seatName'] ?> type="checkbox" class="form-check-input" id="materialInline1">
		  						  <label class="form-check-label" for="materialInline1"><?php echo $seat['seatName'] ?></label>
		  						</div>                       
	                          	
	                        <?php } if ($num_seats == 0) {
	                        	echo '<p class = errmsg>All seats have been reserved for this showtime</p>';
	                        	echo '<button class = btn btn-primary>Select another showtime</button>';

	                        } else { ?>            
	                          
	                            <div class="form-group">
	                            	<input type="submit" id="submit" name="submit" value="Confirm" class="btn btn-primary">
	                            </div>

	                        <?php } ?>
	                             
                                         

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

