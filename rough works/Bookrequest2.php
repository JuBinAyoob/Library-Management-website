
<?php
	session_start();

	if(!isset($_SESSION['myusername']))
		header("location:index.html");
	
	$ID=$_SESSION['ID'];
	$ID=substr($ID,0,1);

	if(isset($_GET['usrid'])&&isset($_GET['usrid']))
	{
		require 'DBconnect.php';
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		require 'DBconnect.php';
		
		$sql="CALL Cancel_Request('$bkrid','$usrid',@flag)";
		$result=mysqli_query($con,$sql);
		$result2=mysqli_query($con,"SELECT @flag");
		if(!$result2 )
			die('Could not call transaction check: ' . mysqli_error($con));
		$row = mysqli_fetch_assoc($result2);	
		
				
		echo '<br>flag =  '.$row['@flag'];
		if($i!=6)
		{
			$sql = "UPDATE transaction SET bookrequest".$i."='$bkrid' WHERE ID='$usrid'";

			$retval = mysqli_query($con,$sql);
			if(!$retval )
				die('Could not update transaction: ' . mysqli_error($con));
		
		
			$sql="SELECT rearpoint,frontpoint FROM bookrequests WHERE mainid='$bkrid'";
			$result=mysqli_query($con,$sql);
			if(!$result )
				die('Could not fetch rearpoint: ' . mysqli_error($con));
			$row = mysqli_fetch_assoc($result);	
		
			$R=$row['rearpoint'];
			$F=$row['frontpoint'];
		
			if($R==-1)
			{
				$sql2 = "UPDATE bookrequests SET rearpoint=0, frontpoint=0, c0='$usrid' WHERE mainid='$bkrid'";

				$retval2 = mysqli_query($con,$sql2);
				if(!$retval2 )
					die('Could not update bookrequests: ' . mysqli_error($con));
			
			}
			else if((($R+1)%16)!=$F)
			{
				$sql2 = "UPDATE bookrequests SET rearpoint=".(($R+1)%16).", c".(($R+1)%16)."='$usrid' WHERE mainid='$bkrid'";

				$retval2 = mysqli_query($con,$sql2);
				if(!$retval2 )
					die('Could not update bookrequests: ' . mysqli_error($con));
			
			}
		
		}
		
		/*if($ID=='S')
			header("location:StudentPage.php");
		else
			header("location:StaffPage.php");*/
	}
	/*else if($ID=='S')
		header("location:StudentPage.php");
	else
		header("location:StaffPage.php");*/
?>