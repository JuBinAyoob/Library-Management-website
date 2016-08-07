<?php
	include ('way2sms-api.php');
	include ('email.php');
	
	require 'DBconnect.php';
	
	$sql="SELECT subid,name,currentuserid,renewtimes FROM books WHERE submissiondate=DATE(now())";
	$result=mysqli_query($con,$sql);

	if(!$result)
		die('Could not get data: ' . mysqli_error($con));
	

	while($row= mysqli_fetch_assoc($result))
	{
		$subid=$row['subid'];
		$user=$row['currentuserid'];
		$bkname=$row['name'];
		
		if($row['renewtimes']==3)
		{
			$sql2="INSERT INTO notification (userid,bookid,type) VALUES('$user','$subid','submission')";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error($con));
			
			$subject='Submission Date Reached';
			$message='You have reached the submission date to return the book   "'
			.$bkname.'"('.$subid.') \n SO Kindly return the book on today itself...';
		}
		else
		{
			$sql2="INSERT INTO notification (userid,bookid,type) VALUES('$user','$subid','renew')";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error($con));
			
			$subject='Renew Book';
			$message='Hey...Go to SIMAT library Site to renew the book     "'.$bkname.'"('.$subid.')';
		}
		
		$sql3="SELECT email,mobno FROM staffandstudent WHERE ID='$user'";
		$result3=mysqli_query($con,$sql3);

		if(!$result3)
			die('Could not get data: ' . mysqli_error($con));
		$row3= mysqli_fetch_assoc($result3);
		
		$to=$row3['email'];
		$mobno=$row3['mobno'];
		
		sendemail("JuBinAyoob","JuB123",$to,$subject,$message);
				
				
		echo "<br>message send to ".$mobno.' : ';

		$res =   sendWay2SMS("8129062800","JuB321",$mobno,$message);
		if(is_array($res)) echo $res[0]['result'] ? 'true' : 'false';
		else echo $res;
		
	}
//========================================================-------------------------------------------------------------------------------	
	
	
//========================================================-------------------------------------------------------------------------------	
	$sql="SELECT Sno,userid,bookid,type FROM notification WHERE (type='renew' or type='accepted') and not_date=DATE_SUB(DATE(now()),INTERVAL 1 DAY)";
	$result=mysqli_query($con,$sql);

	if(!$result)
		die('Could not get data: ' . mysqli_error($con));
	
	while($row= mysqli_fetch_assoc($result))
	{
		if($row['type']=='renew')
		{
			$sql3="DELETE FROM notification WHERE Sno='".$row['Sno']."'";
			$result3=mysqli_query($con,$sql3);

			if(!$result3)
				die('Could not get data: ' . mysqli_error($con));
			
		}
		else
		{
			$usrid=$row['userid'];
			$bkrid=$row['bookid'];
		
			$sql2="CALL Accepted_Cancel('$bkrid','$usrid',@fuser)";
			$result2=mysqli_query($con,$sql2);
			if(!$result2 )
				die('Could not call Accepted Cancel check1: ' . mysqli_error($con));
		
			$result3=mysqli_query($con,"SELECT @fuser");
			if(!$result3 )
				die('Could not call Accepted Cancel check2: ' . mysqli_error($con));
			$row3 = mysqli_fetch_assoc($result3);


			if($row3['@fuser']!='-1')
			{
				$fuser=$row3['@fuser'];
			
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
		}
	}
		
?>