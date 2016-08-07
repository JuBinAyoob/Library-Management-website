
<?php

	if(isset($_GET['usrid'])&&isset($_GET['usrid']))
	{
		require 'DBconnect.php';
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		require 'DBconnect.php';
		
		$d=strtotime("+10 Days");
		$date=date("Y-m-d", $d);
		
		//echo $date."   ".$bkrid;
		
		$sql="CALL Book_Give('$bkrid','$usrid','$date')";
		
		$result=mysqli_query($con,$sql);
		if(!$result )
			die('Could not Give book: ' . mysqli_error($con));
		
		header("location:AdminPage.php?usrid=".$usrid);
	}
	else
		header("location:AdminPage.php");
?>