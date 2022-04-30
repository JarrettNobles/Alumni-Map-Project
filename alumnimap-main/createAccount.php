<?php 
session_start();
  $fname = $lname = $user = $pass = $success = "";
  $fnameErr = $lnameErr = $userErr = $pass1Err = $pass2Err = $emailErr ="";
  $accountCreated = 0;
if($_SESSION['loggedIn'] == 1)
{
	$con = new mysqli('localhost','root','T6BE195pURdRpV','bowker_bd'); 
    if ($con->connect_error)
	{
		die('Could not connect to mySQL: ' . $con->connect_error);
	}
	$career = $con->query("SELECT company, title, lat, lng, yearStart FROM job WHERE alumID = '".$_SESSION['alumID']."'"); 
	$con->close();
}
if(isset($_POST['fname'])){
  //Check out first name
  if(isset($_POST['fname']))
  {
	if(!preg_match("/^[A-Za-z]*$/",$_POST['fname']) )
	  $fnameErr = "Names can only contain letters.";
    else if (empty($_POST['fname']))
		$fnameErr = "Please enter a first name.";
    else
	  $fname = $_POST['fname'];
  }
  
  //Check out last name
  if(isset($_POST['lname']))
  {
	if(!preg_match("/^[A-Za-z]*$/",$_POST['lname']) )
	  $lnameErr = "Names can only contain letters.";
    else if (empty($_POST['fname']))
		$lnameErr = "Please enter a last name.";  
    else
	  $lname = $_POST['lname'];
  }
  
  //Check out the username
  if(isset($_POST['user']))
  {
	if(empty($_POST['user']) || !preg_match("/^[A-Za-z0-9_]+$/",$_POST['user']) )
	  $userErr = "Usernames may only contain letters, numbers, and '_'.";
    else
	  $user = $_POST['user'];
  }
  
  //Check out the email
  if(isset($_POST['email']))
  {
	if(empty($_POST['email']) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",$_POST['email']) )
	  $emailErr = "Please use a valid email address.";
    else
	  $email = $_POST['email'];
  }
  
  //Check that a major is chosen
  if(isset($_POST['majorID']))
  {
	  if(empty($_POST['majorID']))
		$majorIDErr = "Please select a major from the list.";
	  else
		$majorID = $_POST['majorID'];
  }
  
  //Check out the graduation year
  if(isset($_POST['gradYear']))
  {
	if(empty($_POST['gradYear']) || !preg_match("/^[0-9]{4}$/",$_POST['gradYear']) || strcmp($_POST['gradYear'], "1901") < 0 || strcmp($_POST['gradYear'], "2155") > 0 )
	  $gradYearErr = "Please use a valid year.";
    else
	  $gradYear = $_POST['gradYear'];
  }
  
  //check out 1st password
  if(isset($_POST['pass1']))
  {
	if(empty($_POST['pass1']) || !preg_match("/^.{4,16}$/",$_POST['pass1']) )
	  $pass1Err = "Passwords must be 4-16 characters long.";
    //Check if both passwords match.
    else if($_POST['pass1'] != $_POST['pass2'])
	  $pass2Err = "Passwords must match.";
    else
	  $pass = $_POST['pass1'];
  }
   // if there are any errors, make empty all acount creation variables. 
  if(!empty($fnameErr) || !empty($lnameErr) || !empty($userErr) || !empty($passErr) || !empty($emailErr)|| !empty($gradYearErr) ) 
	$fname = $lname = $user = $pass = "";
  //if there are no errors connect to database
  else
  {
	  $con = new mysqli('localhost','root','T6BE195pURdRpV','bowker_bd');
	  if ($con->connect_error)
      {
        die('Could not connect to mySQL in account creation: ' . $con->connect_error);
      }
	  // Check the database for existing username.
	  $sql = "SELECT * FROM alumni WHERE userID = '" . $user . "'";
	  $result = $con->query($sql);
	  if( $result->num_rows > 0 )
		$userErr = "Username already exists.";
	  // If username name does not exists, add account to database.
	  else{
		  $md5pass = md5($pass);
		  $sql = "INSERT INTO alumni (userID, fname, lname, password, email, majorID, gradYear) VALUES ('".$user."','".$fname."', '".$lname."', '".$md5pass."', '".$email."', '".$majorID."', '".$gradYear."')";
		  $con->query($sql);
		  $accountCreated =1;
		  $success = "Account created!";

$result = mysqli_query($con, "SELECT * FROM info");
	$row = $result->fetch_assoc();
	$_SESSION["schoolName"] = $row["schoolName"];
	$_SESSION["schoolURL"] = $row["schoolURL"];







	  } $con->close();
  }
}  
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create An Account</title>
	<link rel="icon" href="MercerSpirit_InterlockingMU.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="StyleSheet" href="homeStyle.css" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		table, th, td {
			border: 1px solid;
			border-collapse: collapse;
		}
		
		th{
			height: 30px;
			vertical-align: middle;
			text-align: center;
			padding-right: 5px;
			padding-left: 5px;
		}		
		
		td{
			height: 30px;
			vertical-align: middle;
			text-align: right;
			padding-right: 5px;
			padding-left: 5px;
		}
		

	</style>	
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand"  <?php echo 'href = "' .$_SESSION["schoolURL"].' ">' ?><?php ECHO $_SESSION["schoolName"]?></a>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="./index.php"><span class="glyphicon glyphicon-globe"></span> Home</a></li>
        <li><a href="./addJob.php"><span class="glyphicon glyphicon-map-marker"></span> Add Marker</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php if ($_SESSION["loggedIn"] == 1){?>

		<?php if ($_SESSION["adminStatus"] == 1){?>
	    		<li><a href="admin.php"><span class="glyphicon glyphicon-cog"></span> Admin</a></li>
		<?php } ?>


		<li><a href=""><span class="glyphicon glyphicon-user"></span> Welcome, <?php echo $_SESSION["name"]?>!</a></li>
		<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>		
		<?php } else { ?>
        <li class="active"><a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
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
      <?php if ($_SESSION["loggedIn"] == 1){?>
	  <h1>Your career profile: </h1>
	  <hr>
	  <table>
			<tr><th>Company</th><th>Title</th><th>Latitude</th><th>Longitude</th><th>Year Started</th></tr>
			<?php
				while($row = $career->fetch_assoc())
				{
					echo "<tr><td> ".$row['company']." </td><td> ".$row['title']." </td><td> ".$row['lat']." </td><td> ".$row['lng']." </td><td> ".$row['yearStart']." </td></tr>";
				}
			?>
	  </table>
	  <?php } else { ?>
	  <h1>Create an account.</h1>
	  <hr/>
	  <?php
        if($accountCreated == 0){
      ?>			
	    <form method="post" action="./createAccount.php">
          * First name:<br>
          <input type="text" name="fname" value="<?php echo $_POST['fname']?>">
		  <?php echo $fnameErr; ?>
		  <br><br>
          * Last name:<br>
          <input type="text" name="lname" value="<?php echo $_POST['lname']?>">
		  <?php echo $lnameErr; ?>
		  <br><br>
          * User name:<br>
          <input type="text" name="user" value="<?php echo $_POST['user']?>">
		  <?php echo $userErr; ?>
		  <br><br>
		  * Email:<br>
          <input type="text" name="email" value="<?php echo $_POST['email']?>">
		  <?php echo $emailErr; ?>
		  <br><br>
		  * Major:<br>


			<?php		
    	$conn=new  mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno()){
		echo"Connection failed";
	}
	
	$result = mysqli_query($conn, "SELECT * FROM major");
	echo'<select name = "majorID">';
	while($row = mysqli_fetch_array($result)){
		echo"<option>$row[majorName]</option>";

	}
	echo"</select>";
	mysqli_close($conn);
?>
			
		
		  <?php echo $majorIDErr; ?>
		<script>
			var expanded =  false
				function showCheckboxes(){
					var checkboxes = document.getElementbyId("checkboxes");
					if(!expanded){
						checkboxes.style.display = "block";
						expanded = true;
					}
					else{
						checkboxes.style.display="none";
						expanded = false;
					}
				}
		
		</script>	
		  <br><br>
		  * Graduation Year:<br>
          <input type="text" name="gradYear" value="<?php echo $_POST['gradYear']?>">
		  <?php echo $gradYearErr; ?>
		  <br><br>
          * Password:<br>
          <input type="password" name="pass1" value="<?php echo $_POST['pass1']?>">
		  <?php echo $pass1Err; ?>
		  <br><br>
          * Re-enter your Password:<br>
          <input type="password" name="pass2" value="<?php echo $_POST['pass2']?>">
		  <?php echo $pass2Err; ?>
		  <br><br>
          <input type="submit" value="Create Account">
        </form><br>
		<p>* Required fields. </p><br>
	  <?php 
	    }
	  else if ($accountCreated == 1)
		  echo "<h2>".$success."</h2><br>";
	  ?>
	 
	  <?php } //closing bracket for loggedIn else statement?>
	  <hr/>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
	<p id="foot">Mercer University &copy; 2022</p>
	</script>
</footer>

</body>
</html>
