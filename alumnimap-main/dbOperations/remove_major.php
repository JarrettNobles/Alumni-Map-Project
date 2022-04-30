<?php

	session_start();
	
	$con = new mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno())
	{
		die('Could not connect to mySQL: ');
	}

//	echo $_POST['new_major'];
//	echo $_POST['new_major_code'];
	$major = $_POST['majorSelected'];

	$sql = "DELETE FROM major WHERE majorName = '$major'";

	echo $sql;
	if(mysqli_query($con, $sql) === TRUE){
		echo "Major Removed";
	}else{
		echo "Error removing major";
	}
	mysqli_close($con);

	header("Location: ../admin.php");
?>	
