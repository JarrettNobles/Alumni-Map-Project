<?php

	session_start();
	
	$con = new mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno())
	{
		die('Could not connect to mySQL: ');
	}

	$user = $_POST['giveAdmin'];

	$sql = "UPDATE alumni SET admin=1 WHERE userID = '$user'";

	echo $sql;
	if(mysqli_query($con, $sql) === TRUE){
		echo "New admin added";
	}else{
		echo "Error adding admin";
	}
	mysqli_close($con);

	header("Location: ../admin.php");
?>	
