<?php

	session_start();
	if(!isset($_SESSION['ID']))
		header("location:index.html");

	if(isset($_GET['usrid'])&&isset($_GET['bkrid']))
	{
		require 'DBconnect.php';
		$usrid=$_GET['usrid'];
		$bkrid=$_GET['bkrid'];
		
		$sql="CALL Accepted_Cancel('$bkrid','$usrid',@fuser)";
		$result=mysqli_query($con,$sql);
		if(!$result )
			die('Could not call Accepted Cancel check1: ' . mysqli_error($con));
		
		$result2=mysqli_query($con,"SELECT @fuser");
		if(!$result2 )
			die('Could not call Accepted Cancel check2: ' . mysqli_error($con));
		$row = mysqli_fetch_assoc($result2);


		if($row['@fuser']!='-1')
		{
			$fuser=$row['@fuser'];
			
			$sql2="SELECT email,mobno FROM staffandstudent WHERE ID='$fuser'";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error($con));
			else
			{
				$row2 = mysqli_fetch_assoc($result2);
				$to=$row2['email'];
				$mobno=$row2['mobno'];
				
				$sql3="SELECT name FROM books WHERE mainid='$bkrid'";
				$result3=mysqli_query($con,$sql3);

				if(!$result3)
					die('Could not get data: ' . mysqli_error($con));
				else
				{
					$row3= mysqli_fetch_assoc($result3);
					$bkname=$row3['name'];
				}
				
				include ('way2sms-api.php');
				include ('email.php');
			
				$subject='Book Request Accepted';
				$message='Hey...The request for the book   "'.$bkname.'"('.$bkrid.')is accepeted,
				Therefore come to library to take it';
				
				sendemail("JuBinAyoob","JuB123",$to,$subject,$message);
				
				echo "<br>message send to ".$mobno.' : ';

				$res =   sendWay2SMS("8129062800","JuB321",$mobno,$message);
				if(is_array($res)) echo $res[0]['result'] ? 'true' : 'false';
				else echo $res;
			}
		}
		
		header("location:Notification.php");
	}
	else
		header("location:Notification.php");
?>