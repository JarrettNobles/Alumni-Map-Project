<?php
	
	session_start();
  	$con = new mysqli('localhost','root','T6BE195pURdRpV','bowker_bd');
 	if ($con->connect_error)
	{
		die('Could not connect to mySQL: ' . $con->connect_error);
    }

	$jobErr = $geoErr = $success = "";
	if (!empty($_POST["company"]) && !empty($_POST["title"]) && !empty($_POST["city"]) ){
		if (!empty($_POST["state"]) || !empty($_POST["country"])){
			$address = "";
			$yearStart = $_POST["yearStart"];
			if(empty($yearStart))
				$yearStart = 9999;
			if(!empty($_POST["street"]))
			{
				$street = preg_replace('/\s+/','+',$_POST["street"]);
				$address .= $street.",+";
			}
			$city = preg_replace('/\s+/','+',$_POST["city"]);
			$address .= $city;
			if(!empty($_POST["state"]))
			{
				$state = preg_replace('/\s+/','+',$_POST["state"]);
				$address .= "+".$state;
			}
			if(preg_match("/^[0-9]{5}$/",$_POST["zip"]))
			{
				$zip = $_POST["zip"];
				$address .= "+".$zip;
			}			
			if(!empty($_POST["country"]))
			{
				$country = preg_replace('/\s+/','+',$_POST["country"]);
				$address .= "+".$country;
			}
			$geocode="https://maps.googleapis.com/maps/api/geocode/json?new_forward_geocoder=true&address=$address&key=AIzaSyBXcL0qF0jOfJI950qbLMh-7sWxQcywyas";
			$x = json_decode(file_get_contents($geocode), true);
			$status = $x["status"];
			if($status != "OK")
				$geoErr = "Invalid address. Please try again.";
			else
			{
				$lat=$x["results"][0]["geometry"]["location"]["lat"];
				$lng=$x["results"][0]["geometry"]["location"]["lng"];
				$con = new mysqli('localhost','root','T6BE195pURdRpV','bowker_bd'); 
				if ($con->connect_error)
				{
					die('Could not connect to mySQL: ' . $con->connect_error);
				}
				$insert = "INSERT INTO job (company, title, lat, lng, alumID, yearStart) VALUES ('".$_POST["company"]."','".$_POST["title"]."','$lat','$lng','".$_SESSION["alumID"]."','$yearStart')";
				$con->query($insert);
				$con->close();

//echo("Reached Here");

				$success = "Marker added. You may add another if you like.";
				
//echo("Reached 2");				
				header("Location: ./index.php");
			}
			

		}
	}
	else if(isset($_POST["company"])||isset($_POST["title"])||isset($_POST["yearStart"])||isset($_POST["street"])||isset($_POST["city"])||isset($_POST["state"])||isset($_POST["zip"])||isset($_POST["country"]))
		$jobErr = "Please review the requirements and try again.";
	
	

	if($_SESSION["loggedIn"] == 1){
	
   
	  //Connects to SQL database on Webclass


	$result = mysqli_query($con, "SELECT * FROM info");
	$row = $result->fetch_assoc();
	$_SESSION["schoolName"] = $row["schoolName"];
	$_SESSION["schoolURL"] = $row["schoolURL"];



	$con ->close();	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add a Map Marker</title>
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
    <a class="navbar-brand"  <?php echo 'href = "' .$_SESSION["schoolURL"].' ">' ?><?php echo $_SESSION["schoolName"]?></a>  
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
        <li class="active"><a href="#"><span class="glyphicon glyphicon-map-marker"></span> Add Marker</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php if ($_SESSION["adminStatus"] == 1){?>
	    		<li><a href="admin.php"><span class="glyphicon glyphicon-cog"></span> Admin</a></li>
		<?php } ?>
		<li><a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Welcome, <?php echo $_SESSION["name"]?>!</a></li>
		<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
	  <p><a href="#"></a></p>
    </div>
    <div id="main" class="col-sm-11 text-left">
<h1>Add career information here:</h1><hr>
<form method="post" action="./addJob.php">
  * Company:<br>
  <input type="text" name="company"><br><br>
  * Title:<br>
  <input type="text" name="title" ><br><br>
  Year Started:<br>
  <input type="text" name="yearStart" ><br><br>
  Street Address:<br>
  <input type="text" name="street" ><br><br>  
  * City:<br>
  <input type="text" name="city" ><br><br>
  ** State:<br>
  <input type="text" name="state" ><br><br>
  Zip:<br>
  <input type="text" name="zip" ><br><br>
  ** Country:<br>
  <input type="text" name="country" ><br><br>
  <p>* = Required.<br>** = Atleast one ** item is required.</p><br>
  <input type="submit" value="Add Marker to Map">
 </form>
 <hr>
 <?php echo "<h3>$jobErr$geoErr$success</h3>";?>
    </div>
  </div>
</div>  

<footer class="container-fluid text-center">
	<p id="foot">Mercer University &copy; 2018</p>
	<script>
		var OSName="Unknown OS";
			if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
			if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
			if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
			if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";
		document.getElementById("foot").innerHTML += " - Current OS: "+OSName
		//document.write(' - Current OS: '+OSName);
	</script>
</footer>

</body>
</html>
<?php
	} //Closing if statement above.
	
	else {//tell user to login to access this feature
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add a Map Marker</title>
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
		<a class="navbar-brand" href="https://mercer.edu">Mercer University</a>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
        <li class="active"><a href="addJob.php"><span class="glyphicon glyphicon-map-marker"></span> Add Marker</a></li>
		<li><a href="#"></a></li>
		<li><a href="#"></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
		  <a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
		  <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>
		</li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-1 sidenav">
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
	  <p><a href="#"></a></p>
    </div>
    <div id="main" class="col-sm-11 text-left">
<h1>Add job information here:</h1><br>
<hr>
<h3>Please login to access this feature.<h3>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
	<p id="foot">Mercer University &copy; 2022</p>
</footer>

</body>
</html>

<?php
	}
?>
