<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php 
	ob_start();
	session_start();

	if(!isset($_SESSION['myusername']))
		header("location:Adminlogin.php");

	require 'DBconnect.php';
?>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>Admin Page</title>
<link rel="stylesheet" type="text/css" href="CSS/adminsearch.css">
<link rel="stylesheet" type="text/css" href="CSS/Menubar.css">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">
</head>

<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">

<ul>
<li><a class="nonactive" href="AdminPage.php">Home</a></li>
<li><a href="AdminNotification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<li><a href="ADDbooks.php">ADD Books</a></li>
<li><a href="ADDuser.php">ADD User</a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules of library</a></li>
<li><a href="Accountsetting.php">Account Settings</a></li>
<li><a href="Adminlogin.php">Logout</a></li>
</ul>
</ul>

<br>
<table style="width: 95%; height: 750px; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="1" cellspacing="0">
	<tbody>
	<tr>
		<td style="vertical-align: top;"> <img style="border: 1px solid ; width: 204px; height: 204px; float: left;" alt="User pic" src="userpics/<?php echo $_SESSION['ID']; ?>.jpg" hspace="10" vspace="15"> <br>
		<br>
		<br>
		Admin Name: &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['myusername'].'</span>'; ?><br>
		ID:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['ID'].'</span>'; ?><br>
		<br>
		<br>
		</td>

		<td style="width: 90%; vertical-align: top; background-color: white; text-align: center;">
		<div class="content">
			<div class="main_logo"></div>
			<div class="main_search">
				<form name="srch" method="post" action="AdminPage.php"> 
				<input name="bookid" class="left" placeholder="BOOK ID" type="text">
				<span style="font-family: Tahoma;" class="left"><br>or</span> 
				<input name="userid" class="left" placeholder="USER ID" type="text"> 
				<input value="SEARCH" class="but" type="submit">
				<div class="clear"></div>
				</form>
			</div>
		</div>

	<br>
	<?php
		
		if(isset($_POST['userid']) || isset($_POST['bookid']))
		{
			$userid = $_POST['userid'];
			//$bookid = $_POST['bookid'];
			//$_SESSION['usid']=$_POST['userid'];
		}
		else if(isset($_GET['usrid']))
			$userid = $_GET['usrid'];
		
		if(isset($userid))
		{		
			if(!empty($userid))
			{
				
				$userid = stripslashes($userid);
				$userid = mysqli_real_escape_string($con,$userid);
	
				$sql="SELECT username,Fine,department FROM staffandstudent WHERE ID='$userid'";
				$result=mysqli_query($con,$sql);

				$count=mysqli_num_rows($result);

				if($count==1&&substr($userid,0,1)!='A')
				{
					if(! $result ) 
						die('Could not get data: ' . mysqli_error());
					else
						$row = mysqli_fetch_assoc($result);
				
					if(substr($userid,0,1)=='S')
						$acttype ="Student";
					else
						$acttype ="Staff";
						
			
					echo '<table style="width: 100%; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
						<tbody>
						<tr>
						<td style="width: 25%; text-align: center;">
							<img style="border: 1px solid ; width: 204px; height: 204px;" alt="User pic" src="userpics/'.$userid.'.jpg">
						</td>
						<td><hr style="width: 100%; height: 2px;">
						User name: &nbsp;<span style="color: red;">'.$row['username'].' </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						User ID: &nbsp;<span style="color: red;">'.$userid.' </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Dept: &nbsp;<span style="color: red;">'.$row['department'].' </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Fine: &nbsp;<span style="color: red;">'.$row['Fine'].' </span>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
						User Type:&nbsp;<span style="color: red;">'.$acttype.'</span><br>
						<hr style="width: 100%; height: 2px;"><br>
						<br></td></tr></tbody></table><br><br>';
						
					
					
					$sql2="SELECT bookathand1,bookathand2,bookathand3 FROM transaction WHERE ID='$userid'";
					$result2=mysqli_query($con,$sql2);

					if(!$result2)
						die('Could not get data: ' . mysqli_error());
					else
					{
						$bk = mysqli_fetch_assoc($result2);
						if(empty($bk['bookathand1'])&&empty($bk['bookathand2'])&&empty($bk['bookathand3']))
							echo '<br><h1 style=" text-align: center; color: red;">No Books Taken......</h1><br><br><br>';
						else
						{
							$book='bookathand';
							$i=1;
							$j=1;
	
							echo '<big style="font-family: Pristina; color: rgb(255, 102, 102); font-weight: bold;"><big>Books at Hand</big></big><br>';
							
							echo '<table style="text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="2" cellspacing="4">
									<tbody>
									<tr>';
					
							while($i<4)
							{
								$bookathandi=$book.$i;
								if(!empty($bk["$bookathandi"]))
								{
									$put=$bk["$bookathandi"];

									$sql3="SELECT name,author,submissiondate,renewtimes FROM books WHERE subid='$put'";
									$retval3 = mysqli_query($con,$sql3);

									if(! $retval3 ) 
										die('Could not get data: ' . mysqli_error());
									else	
									{
										$det = mysqli_fetch_assoc($retval3);
										$url = "Bookreturn.php?usrid=".$userid."&bkrid=".$bk["$bookathandi"];
										echo '<td style="width: 264px; height: 350px; vertical-align: top; text-align: center;">
											<img style="width: 262px; height: 264px;" alt="book pic" src="bookpics/'.substr($bk["$bookathandi"],0,8).'.jpg">
											<br>
											name:&nbsp;<span style="color: red;">'.$det['name'].'</span><br>
											Author:&nbsp;<span style="color: red;">'.$det['author'].'</span><br>
											<br>
											book sub_id:&nbsp;<span style="color: red;">'.$bk["$bookathandi"].'</span><br>
											reniew times:&nbsp;<span style="color: red;">'.$det['renewtimes'].'</span><br>
											Sub_Date:&nbsp;<span style="color: red;">'.$det['submissiondate'].'</span><br>
											<form method="GET" action="confirm.php">
											<input type="hidden" name="link" value="'.$url.'">
											<input type="hidden" name="back" value="AdminPage.php?usrid='.$userid.'">
											<input type="hidden" name="bk" value="'.$bk["$bookathandi"].'">
											<input type="submit" class="but" value="Return Book">
											</form>
											<br></td>';
									}
										
									$j++;
								}
								$i++;
							}
							echo '</tr></tbody></table><br>';
						}
					}
		?>
		<hr><br><br>
		<?php
			
			
				
				
					$sql2="SELECT bookrequest1,bookrequest2,bookrequest3,bookrequest4,bookrequest5 FROM transaction WHERE ID='$userid'";
					$result2=mysqli_query($con,$sql2);

					if(!$result2)
						die('Could not get data: ' . mysqli_error());
					else
					{
						$bk = mysqli_fetch_assoc($result2);
						if(empty($bk['bookrequest1'])&&empty($bk['bookrequest2'])&&empty($bk['bookrequest3'])
							&&empty($bk['bookrequest4'])&&empty($bk['bookrequest5']))
							echo '<br><h1 style=" text-align: center; color: red;">No Books Requested......</h1><br>';
						else
						{
							$book='bookrequest';
							$i=1;
							$j=0;
	
							echo '<big style="font-family: Pristina; color: rgb(255, 102, 102); font-weight: bold;"><big>Books that Requested</big></big><br>';
							
							echo '<table style="text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="2" cellspacing="4">
									<tbody>
									<tr>';
					
							while($i<6)
							{
								$bookrequesti=$book.$i;
								if(!empty($bk["$bookrequesti"]))
								{
									if($j==3)
										echo '</tr><tr>';
									
									$put=$bk["$bookrequesti"];

									$sql3="SELECT name,author FROM books WHERE mainid='$put'";
									$retval3 = mysqli_query($con,$sql3);

									if(! $retval3 ) 
										die('Could not get data: ' . mysqli_error());
									else	
									{
										$det = mysqli_fetch_assoc($retval3);
										echo '<td style="width: 264px; height: 350px; vertical-align: top; text-align: center;">
											<img style="width: 262px; height: 264px;" alt="book pic" src="bookpics/'.substr($bk["$bookrequesti"],0,8).'.jpg">
											<br>
											name:&nbsp;<span style="color: red;">'.$det['name'].'</span><br>
											Author:&nbsp;<span style="color: red;">'.$det['author'].'</span><br>
											<br>
											book main_id:&nbsp;<span style="color: red;">'.$bk["$bookrequesti"].'</span><br>';
										
										$give="SELECT * FROM notification WHERE userid='$userid' and type='accepted' and bookid='".$bk["$bookrequesti"]."'";
										$notify=mysqli_query($con,$give);

										$count=mysqli_num_rows($notify);

										if($count==1)
										{	
											$url = "Bookgive.php?usrid=".$userid."&bkrid=";
											echo '<form method="GET" action="confirm.php">
													<input type="hidden" name="link" value="'.$url.'">
													<input type="hidden" name="back" value="AdminPage.php?usrid='.$userid.'">
													Enter booksubid:<input type="text" name="bk" value="'.$bk["$bookrequesti"].'">
													<input type="submit" class="but" value="Give Book">
													</form>';
										}
										echo '</td>';
									}
										
									$j++;
								}
								$i++;
							}
							echo '</tr></tbody></table><br>';
						}
					}
				}
			}
		}
		?>
<br>
</td>
</tr>
</tbody>
</table>
<?php ob_end_flush();?>
</body></html>