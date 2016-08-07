<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['myusername']))
		header("location:Stafflogin.php");

	require 'DBconnect.php';
	$tbl_name="staffandstudent"; // Table name
	$myuserid=$_SESSION['ID'];
	
	$sql2="SELECT fine,department FROM $tbl_name WHERE ID='$myuserid'";
	
	$retval = mysqli_query($con,$sql2);
   
	if(! $retval ) 
		die('Could not get data: ' . mysqli_error());
	else
		$row = mysqli_fetch_assoc($retval);
	
	$_SESSION['fine']=$row['fine'];
	$_SESSION['department']=$row['department'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Staff Page</title>

<?php require 'style.php'; ?>
<link href="CSS/Menubar.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">
<link rel="stylesheet" type="text/css" href="CSS/butt.css">
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">


<?php require 'searchbar.php'; ?>
  
<ul>
<li><a class="nonactive" href="StaffPage.php">Home</a></li>
<li><a href="Notification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules
of library</a></li>
<li><a href="Accountsetting.php">Account Settings</a></li>
<li><a href="message_admin.php">Contact Librarian</a></li>
<li><a href="Stafflogin.php">Logout</a></li>
</ul>
</ul>
<br>


<table style="width: 95%; height: 750px; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="1" cellspacing="0">
	<tbody>
	<tr>
		<td style="vertical-align: top;">
		<img style="border: 1px solid ; width: 204px; height: 204px; float: left;" alt="User pic" src="userpics/<?php echo $_SESSION['ID']; ?>.jpg" hspace="10" vspace="15"> <br>
		<br>
		<br>
		Staff Name: &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['myusername'].'</span>'; ?><br>
		ID:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['ID'].'</span>'; ?><br>
		Department:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['department'].'</span>'; ?><br>
		<br>
		<br>
		<br>
		<span style="font-family: Tahoma;">Fine in your account : &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['fine'].'</span>'; ?>
		</span><br>
		</td>

		<td style="width: 90%; background-color: white; text-align: center;">
		<br>
		<?php 
			$sql2="SELECT bookathand1,bookathand2,bookathand3 FROM transaction WHERE ID='$myuserid'";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error());
			else
			{
				$bk = mysqli_fetch_assoc($result2);
				if(empty($bk['bookathand1'])&&empty($bk['bookathand2'])&&empty($bk['bookathand3']))
					echo '<br><hr><h1 style=" text-align: center; color: red;">No Books Taken......</h1><hr><br><br><br>';
				else
				{
					$book='bookathand';
					$i=1;
					$j=1;

					echo '<hr><big style="font-family: Pristina; color: rgb(255, 102, 102); font-weight: bold;"><big>Books at Hand</big></big><hr><br><br>';
							
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
								echo '<td style="width: 264px; height: 350px; vertical-align: top; text-align: center;">
									<img style="width: 262px; height: 264px;" alt="book pic" src="bookpics/'.substr($bk["$bookathandi"],0,8).'.jpg">
									<br>
									name:&nbsp;<span style="color: red;">'.$det['name'].'</span><br>
									Author:&nbsp;<span style="color: red;">'.$det['author'].'</span><br>
									<br>
									book sub_id:&nbsp;<span style="color: red;">'.$bk["$bookathandi"].'</span><br>
									reniew times:&nbsp;<span style="color: red;">'.$det['renewtimes'].'</span><br>
									Sub_Date:&nbsp;<span style="color: red;">'.$det['submissiondate'].'</span><br>
									</td>';
							}
									
							$j++;
						}
						$i++;
					}
					echo '</tr></tbody></table><br>';
				}
			}
		?>
		<br>
		<br><br><br>
		<?php 
			$sql2="SELECT bookrequest1,bookrequest2,bookrequest3,bookrequest4,bookrequest5 FROM transaction WHERE ID='$myuserid'";
			$result2=mysqli_query($con,$sql2);

			if(!$result2)
				die('Could not get data: ' . mysqli_error());
			else
			{
				$bk = mysqli_fetch_assoc($result2);
				if(empty($bk['bookrequest1'])&&empty($bk['bookrequest2'])&&empty($bk['bookrequest3'])
					&&empty($bk['bookrequest4'])&&empty($bk['bookrequest5']))
					echo '<br><hr><h1 style=" text-align: center; color: red;">No Books Requested......</h1><hr><br>';
				else
				{
					$book='bookrequest';
					$i=1;
					$j=0;
	
					echo '<hr><big style="font-family: Pristina; color: rgb(255, 102, 102); font-weight: bold;"><big>Books that Requested</big></big><hr><br><br>';
					
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
								
								$sql4="SELECT * FROM notification WHERE userid='$myuserid' and bookid='$put'";
								$retval4 = mysqli_query($con,$sql4);

								if(! $retval4 ) 
									die('Could not get data: ' . mysqli_error());
								
								$count=mysqli_num_rows($retval4);
								$url = "Cancelrequest.php?usrid=".$myuserid."&bkrid=".$bk["$bookrequesti"];
								
								echo '<td style="width: 264px; height: 350px; vertical-align: top; text-align: center;">
									<img style="width: 262px; height: 264px;" alt="book pic" src="bookpics/'.substr($bk["$bookrequesti"],0,8).'.jpg">
									<br>
									name:&nbsp;<span style="color: red;">'.$det['name'].'</span><br>
									Author:&nbsp;<span style="color: red;">'.$det['author'].'</span><br>
									<br>
									book main_id:&nbsp;<span style="color: red;">'.$bk["$bookrequesti"].'</span><br>
									<form method="GET" action="confirm.php">
									<input type="hidden" name="link" value="'.$url.'">
									<input type="hidden" name="back" value="StaffPage.php">
									<input type="hidden" name="bk" value="'.$bk["$bookrequesti"].'">';
									
								if( $count==0) echo '<input type="submit" class="but" value="Cancel Request">';
								else echo '<input type="button" class="but" value="Bookaccepted...">';
									
								echo '
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
		?><br>
</td>
</tr>
</tbody>
</table>


<?php ob_end_flush();?>
</body></html>