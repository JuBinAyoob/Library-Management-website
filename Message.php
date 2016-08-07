<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<?php ob_start();
session_start();

if(!isset($_SESSION['myusername']))
	header("location:index.html");
$userid=$_SESSION['ID'];
$ID=substr($userid,0,1);
?>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Messages</title>

<link href="CSS/bootstrap.css" rel="stylesheet">
<link href="CSS/bootstrap-responsive.css" rel="stylesheet">
<link href="CSS/Menubar.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="CSS/butt.css">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">
</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<ul>
<li><a class="nonactive"<?php if($ID=='A') echo 'href="AdminPage.php"'; else if($ID=='T') echo 'href="StaffPage.php"';else echo 'href="StudentPage.php"'; ?>>Home</a></li>
<li><a <?php if($ID=='A') echo 'href="AdminNotification.php"'; else echo 'href="Notification.php"'; ?>><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules of library</a></li>
<?php if($ID!='A'){ ?>
<li><a href="message_admin.php">Contact Librarian</a></li>
<?php }?>
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
<td style="width: 90%; vertical-align: top; background-color: grey;">


<div class="control-group" style="background-color: pink;">
 <label class="control-label">
	<big style="color: red; font-weight: bold;"><big><big><big> <span style="font-family: Jokerman;">
	<marquee behavior="alternate">Messages</marquee>
	</span></big></big></big></big><br><br>
 </label>
</div>

<?php
	require 'DBconnect.php';
	
	if($ID=='A')
		$sql="SELECT DISTINCT subject,frm,frm_details FROM messages WHERE too='Admin' and status_admin=1 order by sno desc";
	else	
		$sql="SELECT DISTINCT subject,frm,frm_details FROM messages WHERE too='$userid' and status_user=1 order by sno desc";
	
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);
	
	if($count>0)
	{
		$flag=1;
		echo '<table style="background-color: white; width: 90%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2">
				<tbody><tr><td style="text-align: center; font-family: Tahoma; color: red;">from</td>
					       <td style="text-align: center; font-family: Tahoma; color: red;">subject</td>
						   <td style="text-align: center; font-family: Tahoma; color: red;">OPEN</td>
						   <td style="text-align: center; font-family: Tahoma; color: red;">DELETE</td>
						   </tr>';
		while($det = mysqli_fetch_assoc($result))
			echo '<tr><td style="background-color: skyblue; text-align: center;">'.$det['frm_details'].'</td>
						<td style="background-color: skyblue; text-align: center;">'.$det['subject'].'</td>
						<td style="background-color: skyblue; text-align: center;">
						<form method="GET" action="Message_Show.php">
						<input type="hidden" name="msgid" value="'.$det['frm'].'">
						<input type="hidden" name="msgsb" value="'.$det['subject'].'">
						<input type="submit" class="but" name="sub1" value="Open">
						</form></td>
						<td style="background-color: skyblue; text-align: center;"></td>
			     		</tr>';
	}	

	if($ID=='A')
		$sql="SELECT DISTINCT subject,frm,frm_details FROM messages WHERE (too='Admin' or frm LIKE 'A%') and status_admin=0 order by sno desc";
	else	
		$sql="SELECT DISTINCT subject,frm,frm_details FROM messages WHERE (too='$userid' and status_user=0) or frm='$userid' order by sno desc";
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);

	if($count>0)
	{
		if(!isset($flag))
			echo '<table style="background-color: white; width: 90%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2">
					<tbody><tr><td style="text-align: center; font-family: Tahoma; color: red;">from</td>
					       <td style="text-align: center; font-family: Tahoma; color: red;">subject</td>
						   <td style="text-align: center; font-family: Tahoma; color: red;">OPEN</td>
						   <td style="text-align: center; font-family: Tahoma; color: red;">DELETE</td>
						   </tr>';
		$flag=1;
		while($det = mysqli_fetch_assoc($result))
		{	
			echo '<tr><td style="text-align: center;">'.$det['frm_details'].'</td>
						<td style="text-align: center;">'.$det['subject'].'</td>
						<td style="text-align: center;">
						<form method="GET" action="Message_Show.php">
						<input type="hidden" name="msgid" value="'.$det['frm'].'">
						<input type="hidden" name="msgsb" value="'.$det['subject'].'">
						<input type="submit" name="sub1" class="but" value="Open">
						</form></td>
						<td style="text-align: center; font-family: Tahoma; color: red;">
						<form method="GET" action="Message.php">
						<input type="hidden" name="msgid" value="'.$det['frm'].'">
						<input type="hidden" name="msgsb" value="'.$det['subject'].'">
						<input type="submit" name="sub2" class="but" value="DELETE">
						</form></td>
    					</tr>';
		}
		
	}	
	if(!isset($flag))
		echo '<div class="control-group" style="background-color: white; text-align: center;"> <label class="control-label"></label>
				<div class="controls"> 
				<span style="font-family: Tahoma; color: red;">No Message for U....</span>	
				</div></div>';
	else
	{
		echo '</tbody></table><br>';
	}
	
			
?>


</td>
</tr>
</tbody>
</table>
<?php ob_end_flush();?>
</body></html>