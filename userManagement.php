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
		 .tableBody{
        background-color: #071229;
        color:white;
        font-family:Arial, Helevetica, sans-serif;
        font-size:16px;
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
	</style>
</head>
<body class="adminBody">

	<?php include 'header.php';?>

	<div class="container tableBody">
		<span class="input-group">
			<h2>User Management</h2>
	  		<a href = "registerAdmin.php" class="btn btn-primary btnprimaryoveride">Add Admin</a>
	  	</span>
	  
	      
	  <table class="table table-hover">
	    <thead>
	      <tr>
	      	<th>User ID</th>
	        <th>Username</th>
	        <th>Type</th>
	        
	        <th>Edit Account</th>
	        <th>Disable Account</th>
	        
	      </tr>
	    </thead>
	    <tbody>
	      <?php echo $user_list; ?>
	    </tbody>
	  </table>
	</div>


	<?php include 'footer.html';?>

</body>
</html>