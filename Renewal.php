<?php

	session_start();
	if(!isset($_SESSION['ID']))
		header("location:index.html");

	if(isset($_GET['usrid'])&&isset($_GET['bkrid']))
	{
		require 'DBconnect.php';
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		$sql="CALL Renew_Book('$bkrid','$usrid')";
		$result=mysqli_query($con,$sql);
		if(!$result)
			die("Could not update data".mysqli_error($con));
		
		header("location:Notification.php");
	}
	else
		header("location:Notification.php");
?>