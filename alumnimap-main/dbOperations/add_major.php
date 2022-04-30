<?php

	session_start();
	
	$con = new mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno())
	{
		die('Could not connect to mySQL: ');
	}

//	echo $_POST['new_major'];
//	echo $_POST['new_major_code'];
	$major = $_POST['new_major'];
	$major_code = $_POST['new_major_code'];

	$sql = "INSERT INTO major (majorName, majorCode) VALUES ('$major','$major_code')";

	echo $sql;
	if(mysqli_query($con, $sql) === TRUE){
		echo "New major added";
	}else{
		echo "Error adding major";
	}
	mysqli_close($con);

	header("Location: ../admin.php");
?>	
