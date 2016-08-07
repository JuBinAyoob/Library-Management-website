<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<?php ob_start();
session_start();

if(!isset($_SESSION['myusername']))
	header("location:index.html");
$userid=$_SESSION['ID'];
$ID=substr($userid,0,1);
?>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Notifications</title>

<link href="CSS/bootstrap.css" rel="stylesheet">
<link href="CSS/bootstrap-responsive.css" rel="stylesheet">
<link href="CSS/Menubar.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">
</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<ul>
<li><a class="nonactive"<?php if($ID=='A') echo 'href="AdminPage.php"'; else if($ID=='T') echo 'href="StaffPage.php"';else echo 'href="StudentPage.php"'; ?>>Home</a></li>
<li><a href="Notification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules of library</a></li>
<li><a <?php if($ID=='A') echo 'href="Adminlogin.php"'; else if($ID=='T') echo 'href="Stafflogin.php"';else echo 'href="Studentlogin.php"';?>>Logout</a></li>
</ul>
</ul>
<br>
<table style="width: 95%; height: 100%; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="10" cellspacing="0">
<tbody>
<tr>
<td style="vertical-align: top;"> <img style="border: 1px solid ; width: 204px; height: 204px; float: left;" alt="User pic" src="userpics/<?php echo $_SESSION['ID']; ?>.jpg" hspace="10" vspace="15"> <br>
<br>
<br>
User Name: &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['myusername'].'</span>'; ?><br>
ID:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['ID'].'</span>'; ?><br>
</td>
<td style="width: 90%; background-color: white; vertical-align: top; background-color: grey;">


<div class="control-group" style="background-color: pink;">
 <label class="control-label">
	<big style="color: red; font-weight: bold;"><big><big><big> <span style="font-family: Jokerman;">
	<marquee behavior="alternate">Notifications</marquee>
	</span></big></big></big></big><br><br>
 </label>
</div>

<?php
	require 'DBconnect.php';
	
	$sql="SELECT bookid,fine,type FROM notification WHERE userid='$userid' and status=1";
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);

	if($count>0)
	{
		echo '<div class="container" style="width: 100%; height: 20%; text-align: center;">';
	
		while($row = mysqli_fetch_assoc($result))
		{
			
			
			if($row['type']=="accepted")
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE mainid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				$url = "Acceptedcancel.php?usrid=".$userid."&bkrid=".$row['bookid'];
				echo '<div class="control-group" style=" background-color: skyblue;"> 
						<label class="control-label"></label>
						<form method="GET" action="confirm.php">
							<input type="hidden" name="link" value="'.$url.'">
							<input type="hidden" name="bk" value="'.$row["bookid"].'">
							<input type="hidden" name="back" value="Notification.php">
								<div class="controls"> <br> Your request for the book " 
								<span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>", is accepted... 
								<br>if u want to cancel request... press &nbsp;
									<input type="submit" class="btn btn-success" value="Cancel Request">
								</div>
						</form></div>';
				
			}
			else if($row['type']=="renew")
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				$url = "Renewal.php?usrid=".$userid."&bkrid=".$row['bookid'];
				echo '<div class="control-group" style="background-color: skyblue;"> <label class="control-label"></label>
							<form method="GET" action="confirm.php">
							<input type="hidden" name="link" value="'.$url.'">
							<input type="hidden" name="bk" value="'.$row["bookid"].'">
							<input type="hidden" name="back" value="Notification.php">
								<div class="controls"> <br> If u want to renew the book " <span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>", 
								<br> press &nbsp;
									<input type="submit" class="btn btn-success" value="Renew">
								</div>
						</form></div>';
			}
			else if($row['type']=="submission")
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				echo '<div class="control-group" style="background-color: skyblue;"> <label class="control-label"></label>
							<div class="controls"> <br> The date for returning the book " 
							<span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>" is reached,
							<br> So kindly return the book today itself...
						</div></div>';
				
			}
			else //fine notification....
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				echo '<div class="control-group" style="background-color: skyblue;"> <label class="control-label"></label>
						<div class="controls"> <br> Your fine is increased by amount <span style="font-family: Tahoma; color: red;">'.$row['fine'].'</span> for not submitting the book " 
							<span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>" on time...	
						</div></div>';
				
			}
			
		}	
		
	}	

	$sql="SELECT bookid,fine,type FROM notification WHERE userid='$userid' and status=0";
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);

	if($count>0)
	{
		echo '<div class="container" style="width: 100%; height: 20%; text-align: center;">';
		
		while($row = mysqli_fetch_assoc($result))
		{
			
			if($row['type']=="accepted")
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE mainid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				$url = "Acceptedcancel.php?usrid=".$userid."&bkrid=".$row['bookid'];
				echo '<div class="control-group" style=" background-color: white;"> 
						<label class="control-label"></label>
						<form method="GET" action="confirm.php">
							<input type="hidden" name="link" value="'.$url.'">
							<input type="hidden" name="bk" value="'.$row["bookid"].'">
							<input type="hidden" name="back" value="Notification.php">
								<div class="controls"> <br> Your request for the book " 
								<span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>", is accepted... 
								<br>if u want to cancel request... press &nbsp;
									<input type="submit" class="btn btn-success" value="Cancel Request">
								</div>
						</form></div>';
				
			}
			else if($row['type']=="renew")
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE subid='$bkid'";
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				
				$url = "Renewal.php?usrid=".$userid."&bkrid=".$row['bookid'];
				echo '<div class="control-group" style="background-color: white;"> <label class="control-label"></label>
							<form method="GET" action="confirm.php">
							<input type="hidden" name="link" value="'.$url.'">
							<input type="hidden" name="bk" value="'.$row["bookid"].'">
							<input type="hidden" name="back" value="Notification.php">
								<div class="controls"> <br> If u want to renew the book " <span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>", 
								<br> press &nbsp;
									<input type="submit" class="btn btn-success" value="Renew">
								</div>
						</form></div>';
			}
			else if($row['type']=="submission")
			{
				
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				echo '<div class="control-group" style=" background-color: white;"> <label class="control-label"></label>
						<div class="controls"> <br> The date for returning the book " 
							<span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>" is reached,
							<br> So kindly return the book today itself...
						</div></div>';
				
			}
			else //fine notification....
			{
				$bkid=$row['bookid'];
				$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
				$result2=mysqli_query($con,$sql2);

				if(! $result2 ) 
					die('Could not get data: ' . mysqli_error($con));
				else
					$row2 = mysqli_fetch_assoc($result2);
			
				echo '<div class="control-group" style="background-color: white;"> <label class="control-label"></label>
						<div class="controls"> <br> Your fine is increased by amount <span style="font-family: Tahoma; color: red;">'.$row['fine'].'</span> for not submitting the book " 
							<span style="font-family: Tahoma; color: red;">'.$row2['name'].' ( '.$row['bookid'].' )</span>"on time...	
						</div></div>';
				
			}
			
		}			
		echo '</div>';
	}	
	if(!isset($sql2))
		echo '<div class="control-group" style="background-color: white; text-align: center;"> <label class="control-label"></label>
				<div class="controls"> 
				<span style="font-family: Tahoma; color: red;">No Notification for U....</span>	
				</div></div>';
		
	mysqli_query($con,"UPDATE notification SET status=0 WHERE userid='$userid' and status=1");
			
?>


</td>
</tr>
</tbody>
</table>
<?php ob_end_flush();?>
</body></html>