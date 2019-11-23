<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- Latest compiled and minified CSS -->

	<style type="text/css">
		
		body{
			background-color:black;
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

		
       

        .btn-primary{
        	margin-left: 20px;
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

			    <ul class="navbar-nav ml-auto">
			    	<!--if user is logged in display this -->
			    	<?php if( isset($_SESSION['email']) && !empty($_SESSION['email']) )
			        	{
			        ?>

			    	<li class="nav-item ">Welcome <?php echo $_SESSION['email']; ?>  </li>

			      <li class="nav-item ">
			      	<a href="logout.php"><button class="btn btn-primary">Logout</button></a>
			      </li></ul>
			      <!--if user is not logged in display this -->
			       <?php }else{ ?>

			       	<li class="nav-item ">Welcome Guest! </li>

			      <li class="nav-item ">
			      	<a href="login.php"><button class="btn btn-primary">Login</button></a>
			      </li></ul>

			      <?php } ?>
			  
			</nav>
		</header>

</body>
</html>