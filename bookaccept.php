<?php

	include ('way2sms-api.php');
	include ('email.php');
	

function bookaccept()
{
	require 'DBconnect.php';
	do
	{
		$sql="SELECT mainid,frontpoint,rearpoint FROM bookrequests WHERE frontpoint!=-1 and available_books!=0";
		$result=mysqli_query($con,$sql);

		if(!$result)
			die('Could not get data: ' . mysqli_error($con));
	
		$count=mysqli_num_rows($result);

		while($row=mysqli_fetch_assoc($result))
		{
			$mainid=$row['mainid'];
			$F=$row['frontpoint'];
			$R=$row['rearpoint'];
			
			$sql2="SELECT c".$F." FROM bookrequests WHERE mainid='$mainid'";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error($con));
			$row2=mysqli_fetch_assoc($result2);
			
			$user=$row2["c"."$F"];
			
			
			$sql2="SELECT name FROM books WHERE mainid='$mainid'";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error($con));
			$row2=mysqli_fetch_assoc($result2);
			$bkname=$row2['name'];
			
			$subject='Book Request accepted';
			$message='Your request for the book    "'.$bkname.'"('.$mainid.') is accepted...come to library before tommarrow';
			if($F==$R)
			{
				$sql2="UPDATE bookrequests SET available_books=available_books-1,c".$F."='',frontpoint=-1,rearpoint=-1 WHERE mainid='$mainid'";
				$result2=mysqli_query($con,$sql2);

				if(!$result2)
					die('Could not get data: ' . mysqli_error($con));
			}
			else
			{
				$sql2="UPDATE bookrequests SET available_books=available_books-1,c".$F."='',frontpoint=".(($F+1)%16)." WHERE mainid='$mainid'";
				$result2=mysqli_query($con,$sql2);

				if(!$result2)
					die('Could not get data: ' . mysqli_error($con));
				
			}
			
			$sql3="SELECT email,mobno FROM staffandstudent WHERE ID='$user'";
			$result3=mysqli_query($con,$sql3);

			if(!$result3)
				die('Could not get data: ' . mysqli_error($con));
			$row3= mysqli_fetch_assoc($result3);
			$to=$row3['email'];
			$mobno=$row3['mobno'];
				
			$sql3="INSERT INTO notification (userid,bookid,type) VALUES('$user','$mainid','accepted')";
			$result3=mysqli_query($con,$sql3);

			if(!$result3)
				die('Could not get data: ' . mysqli_error($con));	

			sendemail("JuBinAyoob","JuB123",$to,$subject,$message);
			
			echo "<br>message send to ".$mobno.' : ';
			
			$res =   sendWay2SMS("8129062800","JuB321",$mobno,$message);
			if(is_array($res)) echo $res[0]['result'] ? 'true' : 'false';
			else echo $res;
			
		}
		
	}while($count>0);
}
?>