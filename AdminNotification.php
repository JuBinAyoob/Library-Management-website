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
<link rel="stylesheet" type="text/css" href="CSS/butt.css">
</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<ul>
<li><a class="nonactive" href="AdminPage.php">Home</a></li>
<li><a href="AdminNotification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules of library</a></li>
<li><a href="Adminlogin.php">Logout</a></li>
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
	<marquee behavior="alternate">Renew Notifications</marquee>
	</span></big></big></big></big><br><br>
 </label>
</div>

<?php
	require 'DBconnect.php';
	
	$sql="SELECT Sno,bookid,not_date,type FROM notification WHERE userid='admin' and status=1";
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);

	echo '<table style="background-color: white; width: 90%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2">
			<tbody><tr><td style="text-align: center; font-family: Tahoma; color: red;">User ID</td>
						<td style="text-align: center; font-family: Tahoma; color: red;">Book ID</td>
						<td style="text-align: center; font-family: Tahoma; color: red;">Book Name</td>
						<td style="text-align: center; font-family: Tahoma; color: red;">Date</td>
						<td style="text-align: center; font-family: Tahoma; color: red;">DELELTE</td>
				  </tr>';
	if($count>0)
	{
	
		while($row = mysqli_fetch_assoc($result))
		{
			$bkid=$row['bookid'];
			$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
			$result2=mysqli_query($con,$sql2);

			if(! $result2 ) 
				die('Could not get data: ' . mysqli_error($con));
			else
				$row2 = mysqli_fetch_assoc($result2);
			
			$url = "Deletenotification.php?sno=".$row['Sno'];
			echo '<tr>
					<td style="background-color: skyblue; text-align: center;">'.$row["type"].'</td>
					<td style="background-color: skyblue; text-align: center;">'.$row["bookid"].'</td>
					<td style="background-color: skyblue; text-align: center;">'.$row2["name"].'</td>
					<td style="background-color: skyblue; text-align: center;">'.$row["not_date"].'</td>
					<td style="background-color: skyblue; text-align: center;">
						<form method="GET" action="confirm.php">
						<input type="hidden" name="link" value="'.$url.'">
						<input type="hidden" name="bk" value="'.$row["type"].'(bookID: '.$row["bookid"].')">
						<input type="hidden" name="back" value="AdminNotification.php">
						<input type="submit" class="but" value="DELETE">
						</form>
					</td></tr>';	
			
		}	
		
	}	

	$sql="SELECT Sno,bookid,not_date,type FROM notification WHERE userid='admin' and status=0";
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);

	if($count>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$bkid=$row['bookid'];
			$sql2="SELECT name FROM books WHERE subid='$bkid'";
			
			$result2=mysqli_query($con,$sql2);

			if(! $result2 ) 
				die('Could not get data: ' . mysqli_error($con));
			else
				$row2 = mysqli_fetch_assoc($result2);
			
			$url = "Deletenotification.php?sno=".$row['Sno'];
			echo '<tr>
					<td style="text-align: center;">'.$row["type"].'</td>
					<td style="text-align: center;">'.$row["bookid"].'</td>
					<td style="text-align: center;">'.$row2["name"].'</td>
					<td style="text-align: center;">'.$row["not_date"].'</td>
					<td style="text-align: center;">
						<form method="GET" action="confirm.php">
						<input type="hidden" name="link" value="'.$url.'">
						<input type="hidden" name="bk" value="'.$row["type"].'(bookID: '.$row["bookid"].')">
						<input type="hidden" name="back" value="AdminNotification.php">
						<input type="submit" class="but" value="DELETE">
						</form>
					</td></tr>';	
			
		}
		
	}	
	echo '</tbody></table><br>';
	if(!isset($sql2))
		echo '<div class="control-group" style="background-color: white; text-align: center;"> <label class="control-label"></label>
				<div class="controls"> 
				<span style="font-family: Tahoma; color: red;">No Notification for U....</span>	
				</div></div>';
		
	mysqli_query($con,"UPDATE notification SET status=0 WHERE userid='admin' and status=1");
			
?>


</td>
</tr>
</tbody>
</table>
<?php ob_end_flush();?>
</body></html>