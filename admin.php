<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>MyTickets! | Admin Panel</title>
</head>
<body>

	<?php include 'header.php';?>

	<h1>Admin Panel</h1>
	<ul>
	<li><a href="userManagement.php">User management</a></li>
	<li><a href="#">Movie management</a></li>
	<li><a href="#">Booking management</a></li>
	<li><a href="#">Showtime management</a></li>
	</ul>

	<?php include 'footer.html';?>
</body>
</html>