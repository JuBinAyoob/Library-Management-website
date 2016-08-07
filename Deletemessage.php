
<?php

	if(isset($_GET['sno']))
	{
		require 'DBconnect.php';
		$sno=$_GET['sno'];
		
		$sql="DELETE FROM notification WHERE Sno='$sno'";
		
		$result=mysqli_query($con,$sql);
		if(!$result )
			die('Could not request book: ' . mysqli_error($con));
		
		header("location:AdminNotification.php");
	}
	else
		header("location:AdminPage.php");
?>