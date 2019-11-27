<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}



	if (isset($_POST['submit'])) {
			

			$seats = $_POST['seats'];
		  if(empty($seats)) 
		  {
		    echo("You didn't select any seats.");
		  } 
		  else 
		  {
		    $N = count($seats);
		    $cost = $N * 650.00;

		    $seatString = '';

		    echo("You selected $N tickets(s): ");
		    for($i=0; $i < $N; $i++)
		    {
		      $seatString .= $seats[$i] . " ";
		    }
		    	echo '<pre>';
			    echo $_SESSION['userID'];
			    echo $_POST['movie_Name'];
			    echo $_POST['date'];
			    echo $_POST['showtime'];
			    echo "Cost " . $cost;
			    echo $seatString;

			   

			    $userID = mysqli_real_escape_string($connection, $_SESSION['userID']);
			    $movieName = mysqli_real_escape_string($connection, $_POST['movie_Name']);
			    $date = mysqli_real_escape_string($connection, $_POST['date']);
			    $showtime = mysqli_real_escape_string($connection, $_POST['showtime']);

			    $query = "INSERT INTO tickets(userID, tickets, res_date, movieName, showtime_ID, cost) VALUES ('$userID', '$seatString', '$date', '$movieName' , $showtime , $cost)";

			    $result = mysqli_query($connection, $query);

			    if ($result) {
			    	echo "Success";

			    	foreach ($seats as $seat) {
			    		$insert_seat_query = "INSERT INTO reservations VALUES ('$seat', '$date', $showtime)";
			    		$insert_seat_query_result = mysqli_query($connection, $insert_seat_query);
			    	}

			    	// $queryUser = "SELECT * FROM users WHERE userID = $userID LIMIT 1";
			    	// $result2 = mysqli_query($connection, $query);

			    	// $user = mysqli_fetch_assoc($result2);

			    	// $email = $user['email'];

			    	// // the message
			    	// $msg = "Your booking has been confirmed!\nPlease provide this receipt at counter";

			    	// $msg .= "\nMovie Name : "  . $movieName;
			    	// $msg .= "\nReservation Date : "  . $date;
			    	// $msg .= "\nMovie Showtime : "  . $showtime;
			    	// $msg .= "\nSeats : "  . $seatString;
			    	// $msg .= "\nCost : "  . $cost;



			    	// use wordwrap() if lines are longer than 70 characters
			    	//$msg = wordwrap($msg,70);

			    	// send email
			    	//mail($email, "MyTickets - Booking Confirmation",$msg);

			    	header('Location : index.php?Booking_successful');

			    }
			    else{
			    	$errors[] = 'Failed to add record';
			    	echo "Failed";
			    }
			    
		  }

		} ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	


</head>
<body>

	<?php include 'header.php';?>

</body>
</html>