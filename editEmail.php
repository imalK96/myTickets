<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>
<?php 
	if (!isset($_SESSION['userID'])) {
		header('Location: index.php');
	}
?>	

<?php

	$errors = array();
	
	echo "here1";

	if (isset($_POST['emailSubmit'])) {

		echo "here";

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
				header('Location: index.php?email_updated');
			}
			else{
				$errors[] = 'Failed to update record';

				
			}

			} }

 ?>