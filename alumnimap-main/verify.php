<?php
	session_start();
	
	$con = new mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno())
	{
		die('Could not connect to mySQL: ');
	}


	$result = mysqli_query($con, "SELECT * FROM info");
	$row = $result->fetch_assoc();
	$_SESSION["schoolName"] = $row["schoolName"];
	$_SESSION["schoolURL"] = $row["schoolURL"];



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
    <a class="navbar-brand"  <?php echo 'href = "' .$_SESSION["schoolURL"].' ">' ?> <?php echo $_SESSION["schoolName"]?></a>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
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

<div class="col-sm-1 sidenav">
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
      <p><a href="#"></a></p>
	  <p><a href="#"></a></p>
    </div>
<div id="main" class="col-sm-11 text-left">



</div>
  </div>
</div>


<footer class="container-fluid text-center">
	<p id="foot">Mercer University &copy; 2022</p>
</footer>
</body>
</html>

