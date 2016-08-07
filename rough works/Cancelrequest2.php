<?php

	session_start();
	if(!isset($_SESSION['ID']))
		header("location:index.html");
		
	$ID=$_SESSION['ID'];
	$ID=substr($ID,0,1);

	if(isset($_GET['usrid'])&&isset($_GET['usrid']))
	{
		require 'DBconnect.php';
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		require 'DBconnect.php';
		
		for($i=1;$i<=5;$i++)
		{
			$sql = "UPDATE transaction SET bookrequest".$i."=NULL WHERE ID='$usrid' and bookrequest".$i."='$bkrid'";
			$retval = mysqli_query($con,$sql);
			if(!$retval )
				die('Could not update transaction: ' . mysqli_error());
		}
		
		$sql="SELECT rearpoint,frontpoint FROM bookrequests WHERE mainid='$bkrid'";
		$result=mysqli_query($con,$sql);
		if(!$result )
				die('Could not fetch rear and front point: ' . mysqli_error());
		$row = mysqli_fetch_assoc($result);	
		
		$R=$row['rearpoint'];
		$F=$row['frontpoint'];
		
		if($F==$R)
		{
			$sql2 = "UPDATE bookrequests SET rearpoint=-1, frontpoint=-1, c".$F."=NULL WHERE mainid='$bkrid'and c".$F."='$usrid'";
			$retval2 = mysqli_query($con,$sql2);
			if(!$retval2)
				die('Could not update front and rear element: ' . mysqli_error($con));
		
		}
		else
		{
			$sql2 = "UPDATE bookrequests SET frontpoint=".(($F+1)%16).",c".$F."=NULL WHERE mainid='$bkrid'and c".$F."='$usrid'";
			$retval2 = mysqli_query($con,$sql2);
			if(!$retval2 )
				die('Could not update front element: ' . mysqli_error());
			
			for($i=($F+1)%16;$i!=$R;$i=($i+1)%16)
			{
				$sql="SELECT c".$i." FROM bookrequests WHERE mainid='$bkrid'and c".$i."='$usrid'";
				$result=mysqli_query($con,$sql);
				if(!$result )
					die('Could not fetch ci: ' . mysqli_error());
				$row = mysqli_fetch_assoc($result);	
				
				if(!empty($row['c'.$i]))
				{
					$flag=1;
					break;
				}
					
			}
			
			for(;$i!=$R;$i=($i+1)%16)
			{
				$sql="SELECT c".(($i+1)%16)." FROM bookrequests WHERE mainid='$bkrid'";
				$result=mysqli_query($con,$sql);
				if(!$result )
					die('Could not fetch i+1: ' . mysqli_error());
				$row = mysqli_fetch_assoc($result);
				
				$temp=$row['c'.(($i+1)%16)];
				
				$sql3 = "UPDATE bookrequests SET c".$i."='$temp' WHERE mainid='$bkrid'";
				$retval2 = mysqli_query($con,$sql3);
				if(!$retval2 )
					die('Could not update ci: ' . mysqli_error());
				
			}
			if(isset($flag))
			{
				if($R==0)
					$r1=16;
				$sql2 = "UPDATE bookrequests SET rearpoint=".($r1-1).", c".$R."=NULL WHERE mainid='$bkrid'";
				$retval2 = mysqli_query($con,$sql2);
				if(!$retval2 )
					die('Could not update rear element: ' . mysqli_error());
			}
			
			if($R==0)
				$r1=16;
			$sql3 = "UPDATE bookrequests SET rearpoint=".($r1-1).", c".$R."=NULL WHERE mainid='$bkrid'and c".$R."='$usrid'";
			$retval2 = mysqli_query($con,$sql3);
			if(!$retval2 )
				die('Could not update rear element: ' . mysqli_error());
		}
		
		
		
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