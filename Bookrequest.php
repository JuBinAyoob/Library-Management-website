
<?php
	session_start();

	if(!isset($_SESSION['myusername']))
		header("location:index.html");
	
	$ID=$_SESSION['ID'];
	$ID=substr($ID,0,1);

	if(isset($_GET['usrid'])&&isset($_GET['bkrid']))
	{
		require 'DBconnect.php';
		
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		$sql="CALL Req_Book('$bkrid','$usrid')";
		
		$result=mysqli_query($con,$sql);
		if(!$result )
			die('Could not request book: ' . mysqli_error($con));
		
		require 'bookaccept.php';
		bookaccept();
		
		if($ID=='S')
			header("location:StudentPage.php");
		else
			header("location:StaffPage.php");
	}
	else if($ID=='S')
		header("location:StudentPage.php");
	else
		header("location:StaffPage.php");
?>