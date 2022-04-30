<?php
	session_start();

	$con = new mysqli('localhost','root','T6BE195pURdRpV','bowker_bd');
    if ($con->connect_error)
	{
		die('Could not connect to mySQL: ' . $con->connect_error);
    }

	if(empty($_POST["majorID"]))  
		$markers = $con->query("SELECT * FROM job");
	else if($_POST["majorID"] == "Select a Major")
		$markers = $con->query("SELECT * FROM job");
	else if($_POST["majorID"] == "All Majors")
		$markers = $con->query("SELECT * FROM job");
	else
	 	$markers = $con->query("SELECT job.company, job.title, job.lat, job.lng, job.jobID, alumni.fname FROM job LEFT JOIN alumni ON job.alumID = alumni.alumID WHERE alumni.majorID = '".$_POST['majorID']."'");  


$result = mysqli_query($con, "SELECT * FROM info");
	$row = $result->fetch_assoc();
	$_SESSION["schoolName"] = $row["schoolName"];
	$_SESSION["schoolURL"] = $row["schoolURL"];




    $con->close();
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mercer Alumni Map</title>
	<link rel="icon" href="MercerSpirit_InterlockingMU.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="StyleSheet" href="homeStyle.css" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" <?php echo 'href = "' .$_SESSION["schoolURL"].' ">' ?> <?php echo $_SESSION["schoolName"]?></a>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
	<li><a href="addJob.php"><span class="glyphicon glyphicon-map-marker"></span> Add Marker</a></li>
	




	

      </ul>
		
	 <ul class="nav navbar-nav text-nowrap flex-row mx-md-auto order-1 order-md-2">
	 <li class = "nav-item"> <p id = topBar> Selected Major: <?php 

			if ($_POST["majorID"] != ""){
				echo $_POST["majorID"] ;
			}else{
				echo "All Majors";
			}
		
	?> </p></li>






	</ul>
      <ul class="nav navbar-nav navbar-right">
		
		<?php if ($_SESSION["loggedIn"] == 1){?>

		<?php if ($_SESSION["adminStatus"] == 1){?>
	    		<li><a href="admin.php"><span class="glyphicon glyphicon-cog"></span> Admin</a></li>
		<?php } ?>

		<li><a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Welcome, <?php echo $_SESSION["name"]?>!</a></li>
		<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>		
		<?php } else { ?>
        <li><a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
		<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		<?php } ?>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <h3>Alumni Map</h3><br>
	  <p style="text-align:left;">
	  
	  
	  Welcome to the Mercer University Alumni Map! Take a look at where our graduates continue to major in changing the world. Prospective students, see all the possibilities for your future. If you are a Mercer Alum, please create an account and help make our map even better by adding your career information. Use the filter below to narrow down careers by major.
	  <p>
	  	
	  <form method="post" action="./index.php" id="majorsForm">
<?php		
    	$conn=new  mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno()){
		echo"Connection failed";
	}
	
	$result = mysqli_query($conn, "SELECT * FROM major");
	echo'<select name = "majorID" onchange="document.getElementById(\'majorsForm\').submit()">';
	echo"<option>Select a Major</option>";
	echo"<option>All Majors</option>";
	while($row = mysqli_fetch_array($result)){
		echo"<option>$row[majorName]</option>";

	}
	echo"</select>";
//	mysqli_close($conn);

?>
			<br><br>
		</form>
    </div>
    <div id="main" class="col-sm-10 text-left"> 
	<div id=map>
	<script type='text/javascript'>
	var map;
      function initMap() {
		var myLatLng 
		
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 32.841, lng: -83.632},
          zoom: 7
        });

		
		<?php for($i = 0; $i < $markers->num_rows; $i++){ 
			$row = $markers->fetch_assoc();
		
?>
			var marker<?php echo $i?>= new google.maps.Marker({
			position: {lat: <?php echo $row["lat"];?>, lng: <?php echo $row["lng"];?>},
			map: map,
			title: '<?php echo $row["company"];?> - <?php echo $row["title"];?>'
			});
			//jarrett

      
       var infowindow<?php $i ?> = new google.maps.InfoWindow({
       content:  <?php

			$result = mysqli_query($conn, "SELECT * FROM job left join alumni on job.alumID = alumni.alumID WHERE $row[jobID] = job.jobID");
			$row2 = $result->fetch_assoc();
			echo '"';
			//echo $row2['fname'];
			echo 'Test Popup';
			echo'"';
	?>
                  });
          marker<?php echo $i?>.addListener('click', function() {
	  infowindow<?php $i ?>.open(map, marker<?php echo $i?>);
        });


			 <?php } ?>
     			 }
      




    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXcL0qF0jOfJI950qbLMh-7sWxQcywyas&callback=initMap"
    async defer>
	</script> 
	  </div>		
    </div>
  </div>
</div>
 

<footer>
	<p id="foot">Mercer University &copy; 2022</p>
		
</footer>

</body> 
</html>
