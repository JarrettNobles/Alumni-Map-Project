<?php

	session_start();
	
	$con = new mysqli('localhost', 'root', 'T6BE195pURdRpV', 'bowker_bd');
	if(mysqli_connect_errno())
	{
		die('Could not connect to mySQL: ');
	}

	$school = $_POST['newSchoolName'];	
	$url = $_POST['newSchoolURL'];


	$sql = "UPDATE info SET schoolName = '$school'";
	$sql2 = "UPDATE info SET schoolURL = '$url'";

	echo $sql;

	if(!empty($school)){
		if(mysqli_query($con, $sql) === TRUE){
			echo "New school name added";
		}else{
			echo "Error adding school name";
		}
	}
	if(!empty($url)){
		if(mysqli_query($con, $sql2) === TRUE){
			echo "New school url added";
		}else{
			echo "Error adding school url";
		}
		mysqli_close($con);
	}

	header("Location: ../admin.php");
?>	
