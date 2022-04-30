<?php
//Brandon Bowker Chris Mathis IST351
//Logout Page
	session_start();
    session_unset();
	session_destroy();
	
?>  


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Logout</title>
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
      <ul class="nav navbar-nav navbar-left">
        <li><a href="./index.php"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
        <li><a href="./addJob.php"><span class="glyphicon glyphicon-map-marker"></span> Add Marker</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="./createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
		<li><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
      <h1>You have logged out.</h1>
	  <hr/>
	  <h4>
	    You can still view the map, but you must log back in to add markers.
	  </h4>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
	<p id="foot">Mercer University &copy; 2022</p>
</footer>

</body>
</html>
