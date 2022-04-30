<?php
//Brandon Bowker Chris Mathis IST351


    session_start();
	$loginErr = "";
	if(isset ($_POST["username"]))
    {
      $username=$_POST["username"];
      $password = md5($_POST["password"]);
    
	  //Connects to SQL database on Webclass
	  $con = new mysqli('localhost','root','T6BE195pURdRpV','bowker_bd'); 
      if ($con->connect_error)
	  {
		die('Could not connect to mySQL: ' . $con->connect_error);
	  }

	$result = mysqli_query($con, "SELECT * FROM info");
	$row = $result->fetch_assoc();
	$_SESSION["schoolName"] = $row["schoolName"];
	$_SESSION["schoolURL"] = $row["schoolURL"];


	//Queries database for user & password match
	  $sqlLogin = "SELECT * FROM alumni WHERE userID = '" . $username . "' AND password = '" . $password . "'";
	  
	  $result = $con->query($sqlLogin);
	  if ($result->num_rows == 1) 
	  {
		  
		$row = $result->fetch_assoc();
		$_SESSION["name"] = $row["fname"];
		$_SESSION["alumID"] = $row["alumID"];
	    $_SESSION["loggedIn"] = 1;
		$_SESSION["adminStatus"] = $row["admin"];
		header('Location: ./index.php');
	  }
	  else
	  {
	    $loginErr = "Login Failed.";
	  }
	  $con->close();
    }
?>  


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login to the Alumni Map</title>
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
		<a class="navbar-brand"  <?php echo 'href = "' .$_SESSION["schoolURL"].' ">' ?> <?php echo $_SESSION["schoolName"]?></a>
		
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-left">
        <li><a href="./index.php"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
        <li><a href="./addJob.php"><span class="glyphicon glyphicon-map-marker"></span> Add Marker</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="./createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
		<li class="active"><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
      <h1>Please login.</h1>
	  <?php echo "<h4>".$loginErr."</h4>"; ?>
	  <hr/>
      <form method="post" action="login.php">
	  <table>
      <tr><td>UserID: </td><td><input type="text" name="username" /></td></tr>
      <tr><td>Password: </td><td><input type="password" name="password" /><td></tr>
	  </table>
      <input type="submit" value="Login" /><br/>
      </form>
		
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
	<p id="foot">Mercer University &copy; 2022</p>
</footer>
</body>
</html>
