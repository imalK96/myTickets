<?php 

	$connection = mysqli_connect('localhost', 'root', '', 'mytickets');

	//Checking the connection
	if (mysqli_connect_errno()) 
	{
		die('Database connection failed');
	}
	else
	{
		//echo "Connection Successful!";
	}

 ?>