<?php session_start(); ?>
<?php require_once('Includes/dbconnect.php'); ?>

<?php


	$query = "SELECT * FROM movie";

	$movies = mysqli_query($connection, $query);

	$num_rows = mysqli_num_rows($movies);



 ?>

<!DOCTYPE html>
<html>
<head>
	<title>MyTickets!</title>
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
		.card-body {
		    min-height: 300px;
		    min-width: 200px;
		    margin-right: 5px;
		    margin-top: 20px;
		    box-shadow: 0 4px 8px 0 white;
        	transition: 0.3s;
        	background-color: black;
        	color: white;

		}
		.card-body h5{
			padding-top: 8px;
			font-size: 16px;
		}
		.navbar_override{
			background-color:#071229;
			color: white;
		}

		
        .card-body:hover {
        box-shadow: 0 8px 16px 0 #2374C4;
        }

        .btn-primary{
        	margin-left: 20px;
        }
        a.custom-card,
a.custom-card:hover {
  color: inherit;
}

	</style>

	 <script type="text/javascript">
        var image1 = new Image()
        image1.src="./Images/MI_slide.jpg" 

        var image2 = new Image()
        image2.src="./Images/JW_slide.jpg"

        var image3 = new Image()
        image3.src="./Images/HT_slide.jpg"

     </script>

</head>
<body>



	<img class="header_img" src="./Images/MI_slide.jpg" name="slide" width="100%">
    <script type="text/javascript">
        var step = 1
        function slideit(){
            document.images.slide.src=eval("image"+step+".src")
        if(step<3)
        step++

        else
        step=1

        setTimeout("slideit()",4000)
        }
        slideit()
        
    </script>
		
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
			        <a class="nav-link text-light" href="bookings.php">Book Now</a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link text-light" href="#">Showtimes</a>
			      </li>
			      <!--if user is logged in display this -->
			    	<?php if( isset($_SESSION['email']) && !empty($_SESSION['email']) && $_SESSION['type'] == 'admin'  )
			        	{
			        ?>
					      <li class="nav-item">
					        <a class="nav-link text-light" href="admin.php">Admin</a>
					      </li>
			       <?php }else if (isset($_SESSION['email']) && !empty($_SESSION['email']) && $_SESSION['type'] == 'user'  ){ ?>
			       		<li class="nav-item">
					        <a class="nav-link text-light" href="profile.php">Profile</a>
					      </li>

			       <?php } ?>
			      			     
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

<!--main cards movies-->

		<div class="container-fluid text-center ">
	    <div class="row flex-row ">
	   

	    	<?php while ($movie = mysqli_fetch_assoc($movies)) {
	    	
	    	?>
	       <div class="col d-flex align-items-stretch">
	            <div class="card card-block card-body">
	            	 <?php echo "<a class= 'custom-card' href = \"bookings.php?movie_ID={$movie['movie_ID']}\">"; ?>
	            	<img src=<?php echo $movie['img_Path']; ?> alt="Avatar" style="width:100%; ">
	                <div class="cardContainer">
	                  <h5><b><?php echo $movie['movie_Name']; ?></b></h5> <br>
	                  <button class="btn btn-primary">Book Now</button>
	                </div>
	                </a>
	            </div>
	        </div>
	        	    <?php } ?>
	        
	        

	      
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