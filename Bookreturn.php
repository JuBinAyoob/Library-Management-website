
<?php

	if(isset($_GET['usrid'])&&isset($_GET['bkrid']))
	{
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		require 'DBconnect.php';
		
		$sql="CALL Book_Return('$bkrid','$usrid')";
		
		$result=mysqli_query($con,$sql);
		if(!$result )
			die('Could not request book: ' . mysqli_error($con));
		
		require 'bookaccept.php';
		bookaccept();
		
		header("location:AdminPage.php?usrid=".$usrid);
	}
	else
		header("location:AdminPage.php");
?>