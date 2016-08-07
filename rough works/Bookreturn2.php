
<?php

	if(isset($_GET['usrid'])&&isset($_GET['usrid']))
	{
		require 'DBconnect.php';
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		require 'DBconnect.php';
		
		for($i=1;$i<=3;$i++)
		{
			$sql = "UPDATE transaction SET bookathand".$i."=NULL WHERE ID='$usrid' and bookathand".$i."='$bkrid'";

			$retval = mysqli_query($con,$sql);
			if(!$retval )
				die('Could not update data: ' . mysqli_error());
		}
		
		$sql2 = "UPDATE books SET currentuserid=NULL,submissiondate=NULL,renewtimes=0 WHERE subid='$bkrid'";

		$retval2 = mysqli_query($con,$sql2);
		if(!$retval2 )
			die('Could not update data: ' . mysqli_error());
		
		header("location:AdminPage.php?usrid=".$usrid);
	}
	else
		header("location:AdminPage.php");
?>