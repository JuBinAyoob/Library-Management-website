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


<?php
	if(isset($_GET['sub1']))
	{
		$from=$_GET['msgid'];
		$subject=$_GET['msgsb'];
		
		echo '<div class="control-group" style="background-color: pink;">
			<label class="control-label">
			<center>Messages of:
			<big style="color: red;"><span style="font-family: Tahoma;">
			'.$from.'</span></big><br><br>
			Subject:
			<big style="color: red;"><span style="font-family: Tahoma;">
			'.$subject.'
			</span></big></center><br>
			</label>
			</div>';
		require 'DBconnect.php';
	
		if($ID=='A')
			$sql="SELECT frm,message FROM messages WHERE frm='$from' and subject='$subject' and status_admin=1 order by sno desc";
		else
			$sql="SELECT frm,message FROM messages WHERE too='$userid' and subject='$subject' and status_user=1 order by sno desc";
		
			
		$result=mysqli_query($con,$sql);

		if(! $result ) 
			die('Could not get data: ' . mysqli_error($con));
		else
			$count=mysqli_num_rows($result);
	
		if($count>0)
		{
			echo '<div class="control-group" style="background-color: skyblue;">';
			while($det = mysqli_fetch_assoc($result))
				if($det['frm']==$userid)
					echo '<label class="control-label"> Me:     '.$det['message'].'<br></label>';
				else
					echo '<label class="control-label">'.$det['frm'].':     '.$det['message'].'<br></label>';
		}	
		
		
		if($ID=='A')
			$sql="SELECT frm,message FROM messages WHERE ( frm='$from' or too='$from' ) and subject='$subject' and status_admin=0 order by sno desc";
		else
			$sql="SELECT frm,message FROM messages WHERE (too='$userid' or frm='$userid') and subject='$subject' and status_user=0 order by sno desc";
		
			
		$result=mysqli_query($con,$sql);

		if(! $result ) 
			die('Could not get data: ' . mysqli_error($con));
		else
			$count=mysqli_num_rows($result);
	
		if($count>0)
		{
			echo '<div class="control-group" style="background-color: white;">';
			while($det = mysqli_fetch_assoc($result))
				if($det['frm']==$userid)
					echo '<label class="control-label"> Me:     '.$det['message'].'<br></label>';
				else
					echo '<label class="control-label">'.$det['frm'].':     '.$det['message'].'<br></label>';
		}

		if($ID=='A')
			$sql=" UPDATE messages SET status_admin=0 WHERE frm='$from' and subject='$subject' and status_admin=1 order by sno desc";
		else
			$sql="UPDATE messages SET status_user=0 WHERE too='$userid' and subject='$subject' and status_user=1 order by sno desc";
		
			
		$result=mysqli_query($con,$sql);

		if(! $result ) 
			die('Could not get data: ' . mysqli_error($con));

	}
	
			
?>


</td>
</tr>
</tbody>
</table>
<?php ob_end_flush();?>
</body></html>