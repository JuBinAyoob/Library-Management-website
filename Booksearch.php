
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php 
	ob_start();
	session_start();

	if(!isset($_SESSION['myusername']))
		header("location:index.html");
	
	$usid=$_SESSION['ID'];
	$ID=substr($usid,0,1);

	require 'DBconnect.php';
?>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>Booksearch</title>
<?php require 'style.php'; ?>
<link rel="stylesheet" type="text/css" href="CSS/Menubar.css">
<link rel="stylesheet" type="text/css" href="CSS/butt.css">
</head>

<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">

<?php require 'searchbar.php'; ?>

<ul>
<li><a class="nonactive" <?php if($ID=='T') echo 'href="StaffPage.php"'; else echo 'href="StudentPage.php"';?>>Home</a></li>
<li><a href="Notification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules of library</a></li>
<li><a href="Accountsetting.php">Account Settings</a></li>
<li><a <?php if($ID=='T') echo 'href="Stafflogin.php"'; else echo 'href="Studentlogin.php"';?>>Logout</a></li>
</ul>
</ul>

<br>
<table style="width: 95%; height: 750px; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="1" cellspacing="0">
	<tbody>
	<tr>
		<td style="vertical-align: top;"> <img style="border: 1px solid ; width: 204px; height: 204px; float: left;" alt="User pic" src="userpics/<?php echo $_SESSION['ID']; ?>.jpg" hspace="10" vspace="15"> <br>
		<br>
		<br>
		Name: &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['myusername'].'</span>'; ?><br>
		ID:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['ID'].'</span>'; ?><br>
		Department:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['department'].'</span>'; ?><br>
		<br>
		<br>
		<br>
		<span style="font-family: Tahoma;">Fine in your account : &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['fine'].'</span>'; ?>
		</span><br>
		<br>
		<br>
		</td>

		<td style="width: 90%; vertical-align: top; background-color: white; text-align: center;">
		
		<br><br><br>
		<?php 
		
		echo '<hr><big style="font-family: Pristina; color: rgb(255, 102, 102); font-weight: bold;"><big>Books search result</big></big><hr><br><br>';
			
		
		if(isset($_POST['searchbk'])&&!empty($_POST['searchbk']))
		{
					
			$bkname=$_POST['searchbk'];

			$sql3="SELECT mainid,author FROM books WHERE name='$bkname'";
			$result = mysqli_query($con,$sql3);

			$count=mysqli_num_rows($result);
			
			if(! $result ) 
				die('Could not get data: ' . mysqli_error($con));
			else if($count!=0)
			{
				echo '<table style="text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="2" cellspacing="4">
					<tbody>
					<tr>';		
					
				$det = mysqli_fetch_assoc($result);
				echo '<td style="width: 264px; height: 350px; vertical-align: top; text-align: center;">
						<img style="width: 262px; height: 264px;" alt="book pic" src="bookpics/'.$det['mainid'].'.jpg">
						<br>
						name:&nbsp;<span style="color: red;">'.$bkname.'</span><br>
						Author:&nbsp;<span style="color: red;">'.$det['author'].'</span><br>
						<br>
						book main_id:&nbsp;<span style="color: red;">'.$det['mainid'].'</span><br>';
				
				$bkid=$det['mainid'];
				$sql="CALL Check_Transaction('$bkid','$usid',@flag)";
				$result=mysqli_query($con,$sql);
				if(!$result )
					die('Could not call transaction check1: ' . mysqli_error($con));
		
				$result2=mysqli_query($con,"SELECT @flag");
				if(!$result2 )
					die('Could not call transaction check2: ' . mysqli_error($con));
				$row = mysqli_fetch_assoc($result2);	
		
				
				if($row['@flag']==0)		
				{
					$url = "Bookrequest.php?usrid=".$_SESSION['ID']."&bkrid=".$det['mainid'];
					echo '<form method="GET" action="confirm.php">
							<input type="hidden" name="link" value="'.$url.'">
							<input type="hidden" name="back" value="Booksearch.php">
							<input type="hidden" name="bk" value="'.$det['mainid'].'">
							<input type="submit" class="but" value="Request Book">
							</form>
							<br></td>';
				}
				else if($row['@flag']==1)
					echo '<input type="submit" class="but" value="U have this book"></td>';
				else if($row['@flag']==2)
				{
					$url = "Cancelrequest.php?usrid=".$_SESSION['ID']."&bkrid=".$det['mainid'];
					echo '<form method="GET" action="confirm.php">
							<input type="hidden" name="link" value="'.$url.'">
							<input type="hidden" name="back" value="Booksearch.php">
							<input type="hidden" name="bk" value="'.$det['mainid'].'">
							<input type="submit" class="but" value="Cancel The Request">
							</form>
							<br></td>';
				}
				else if($row['@flag']==4)
				{
					echo '<input type="button" class="but" value="Book Accepted...">
						<br></td>';
							
				}
				else
					echo '<input type="submit" class="but" value="You can\'t request this book..."><br>
						(Ur requests is at maximum level or U have already taken 3 books )</td>';
			}
			echo '</tr></tbody></table><br>';
		}
		?>
		<br>
		</td>
</tr>
</tbody>
</table>
<?php ob_end_flush();?>
</body></html>