<?php

	session_start();
	
	$con = new mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno())
	{
		die('Could not connect to mySQL: ');
	}

	$user = $_POST['userSelected'];

	$myID = mysqli_query($con, "SELECT alumID from alumni where userID = '$user'");
	$row = mysqli_fetch_array($myID);


	$sql = "DELETE FROM alumni WHERE userID = '$user'";

	echo $sql;
	if(mysqli_query($con, $sql) === TRUE){
		echo "User Removed";
	}else{
		echo "Error Removing User";
	}

	$sql2 = "DELETE FROM job WHERE alumID = $row[0]";
echo $sql2;
	if(mysqli_query($con, $sql2) === TRUE){
		echo "Successfully removed jobs for entered user";
	}else{
		echo "Error removing jobs";
	}

	mysqli_close($con);

	header("Location: ../admin.php");
?>	

