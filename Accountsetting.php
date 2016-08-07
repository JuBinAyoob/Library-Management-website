<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<?php ob_start();
	session_start();
	if(!isset($_SESSION['myusername']))
		header("location:index.html");

	$ID=$_SESSION['ID'];
	$ID=substr($ID,0,1);
	require 'DBconnect.php';
	
?>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Account Settings</title>

<?php
if($ID!="A")
	require 'style.php';
?>

<link href="CSS/bootstrap.css" rel="stylesheet" />
<link href="CSS/bootstrap-responsive.css" rel="stylesheet" />
<link href="CSS/Menubar.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">
</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<?php
if($ID!="A")
	require 'searchbar.php';
?>
<ul>
<li><a class="nonactive" <?php if($ID=='A') echo 'href="AdminPage.php"'; else if($ID=='T') echo 'href="StaffPage.php"';else echo 'href="StudentPage.php"';?>>Home</a></li>
<li><a <?php if($ID=='A') echo 'href="AdminNotification.php"'; else echo 'href="Notification.php"'; ?>><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules
of library</a></li>
<li><a <?php if($ID=='A') echo 'href="Adminlogin.php"'; else if($ID=='T') echo 'href="Stafflogin.php"';else echo 'href="Studentlogin.php"';?>>Logout</a></li>
</ul>
</ul>
<br>


<table style="width: 95%; height: 100%; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="10" cellspacing="0">
	<tbody>
	<tr>
		<td style="vertical-align: top;">
		<img style="border: 1px solid ; width: 204px; height: 204px; float: left;" alt="User pic" src="userpics/<?php echo $_SESSION['ID']; ?>.jpg" hspace="10" vspace="15"> <br>
		<br>
		<br>
		Name: &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['myusername'].'</span>'; ?><br>
		ID:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$_SESSION['ID'].'</span>'; ?><br>
		<br>
		</td>

		<td style="width: 90%; background-color: white; vertical-align: top;" >
		<br>
		<br>
		<?php
			
			$id=$_SESSION['ID'];
	
			if(isset($_POST['chgmbno']))
			{
				$newmbno=$_POST['chgmbno'];
	
				$newmbno = stripslashes($newmbno);
				$newmbno = mysqli_real_escape_string($con,$newmbno);
		
				$sql = "UPDATE staffandstudent SET mobno='$newmbno' WHERE ID='$id'";

				$retval = mysqli_query($con,$sql);
			}
				
			if(isset($_POST['chgemail']))
			{
				$newemail=$_POST['chgemail'];
		
				$newemail = stripslashes($newemail);
				$newemail = mysqli_real_escape_string($con,$newemail);
		
				$sql = "UPDATE staffandstudent SET email='$newemail' WHERE ID='$id'";

				$retval = mysqli_query($con,$sql);
			}
			
			$sql="SELECT email,mobno FROM staffandstudent WHERE ID='$id'";
			$result=mysqli_query($con,$sql);
	
			if(!$result)
				echo "Could not select data...";
			$row=mysqli_fetch_assoc($result);
		?>
		<center>
		email: &nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$row['email'].'</span>'; ?><br>
		mobno:&nbsp;<?php echo '<span style="font-family: Tahoma; color: red;">'.$row['mobno'].'</span>'; ?>
		</center><br>
		<br>
		<br>
		<div class="container" style=" width:50%; height:100%; " >
		<form class="form-horizontal" name="accountsetting" method="post" action="Accountsetting.php">
		<fieldset>
		<legend>Account Settings</legend>
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<center>Change</center><br>
					<input type="radio" name="choice" value="mbno">Mobile No
					<input type="radio" name="choice" value="email">Email
					<input type="radio" name="choice" value="password">Password
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" name="sub1" class="btn btn-success">Enter</button>
				</div>
			</div>
		</fieldset>
		</form>
		</div>
		
		
		<?php
			if(isset($_POST['choice']))
			{
				if($_POST['choice']=="mbno")
				{
		?>
		<div class="container" style=" width:50%; height:100%; " >
		<form class="form-horizontal" name="changembno" method="post" action="Accountsetting.php">
			<fieldset>
			<legend>Change Mobile No</legend>
			
			<div class="control-group">
				<label class="control-label">Enter New Mobile no:</label>
				<div class="controls">
					<input type="number" name="chgmbno" id="chgmbno" required >
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" name="Submit" class="btn btn-success">Change Mobile No</button>
				</div>
			</div>
		</fieldset>
		</form>
		</div>
		
		<?php
				}
				else if($_POST['choice']=="email")
				{
		?>
		<div class="container" style=" width:50%; height:100%; " >
		<form class="form-horizontal" name="changeemail" method="post" action="Accountsetting.php">
			<fieldset>
			<legend>Change Email</legend>
			
			<div class="control-group">
				<label class="control-label">Enter new email:</label>
				<div class="controls">
					<input name="chgemail" id="chgemail" type="email" required />
				</div>
			</div>	
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" name="Submit" class="btn btn-success">Change Email</button>
				</div>
			</div>
		</fieldset>
		</form>
		</div>
				
				
		<?php
				}
				else if($_POST['choice']=="password")
				{
		?>
		<div class="container" style=" width:50%; height:100%; " >
		<form class="form-horizontal" name="changepassword" method="post" action="Accountsetting.php">
			<fieldset>
			<legend>Change Password</legend>
			
			<div class="control-group">
				<label class="control-label">Old password:</label>
				<div class="controls">
					<input name="oldpassword" id="oldpassword" type="password" required />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">New password:</label>
				<div class="controls">
					<input name="newpassword" id="newpassword" type="password" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Confirm password:</label>
				<div class="controls">
					<input input name="confirmpassword" id="confirmpassword" type="password" required />
				</div>
			</div>
			
			<?php
			if(isset($_POST['oldpassword'])&&isset($_POST['newpassword'])&&isset($_POST['confirmpassword']))
			{
				
			}
			?>
			
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" name="Submit" class="btn btn-success">Change Password</button>
				</div>
			</div>
		</fieldset>
	</form>
	

	</div>
	
	<?php 
				}
			}
	
				if(isset($_POST['oldpassword'])&&isset($_POST['newpassword'])&&isset($_POST['confirmpassword']))
				{
					// username and password sent from form
					$oldpass=$_POST['oldpassword'];
	
					// To protect MySQL injection (more detail about MySQL injection)
					$oldpass = stripslashes($oldpass);
					$oldpass = mysqli_real_escape_string($con,$oldpass);
	
	
					$sql="SELECT * FROM users WHERE ID='$id' and password='$oldpass'";
					$result=mysqli_query($con,$sql);

					// Mysql_num_row is counting table row
					$count=mysqli_num_rows($result);
	
	
					// If result matched $myuserid and $oldpass, table row must be 1 row
					if(!$count==1) 
						echo '<div class="control-group"> 
							<label class="control-label"></label>
							<div class="controls" style="color:red"><center>Wrong Password</center></div></div>';
					else
					{
						if($_POST['newpassword'] == $_POST['confirmpassword'])
						{
							$newpass=$_POST['newpassword'];
			
							$newpass = stripslashes($newpass);
							$newpass = mysqli_real_escape_string($con,$newpass);
		
							//$usernam=$_SESSION['username'];
							$sql = "UPDATE users SET password='$newpass' WHERE ID='$id'";

							//mysqli_select_db('libmng');
							$retval = mysqli_query($con,$sql);
							if(! $retval )
								die('Could not update data: ' . mysqli_error());
							else
								echo '<div class="control-group"> 
								<label class="control-label"></label>
								<div class="controls" style="color:red"><center>Password Successfully Changed</center></div></div>';
						}
						else
							echo '<div class="control-group"> 
								<label class="control-label"></label>
								<div class="controls" style="color:red"><center>Wrong Combination of password</center></div></div>';
					}
	
				}
				
				if(isset($_POST['chgmbno']))
				{
					if(! $retval )
						die('Could not update data: ' . mysqli_error());
					else
						echo '<div class="control-group"> 
							<label class="control-label"></label>
							<div class="controls" style="color:red"><center>Mobile no Successfully Changed</center></div></div><br><br>';
				}
				
				if(isset($_POST['chgemail']))
				{
					if(! $retval )
						die('Could not update data: ' . mysqli_error());
					else
						echo '<div class="control-group"> 
							<label class="control-label"></label>
							<div class="controls" style="color:red"><center>Email Successfully Changed</center></div></div><br><br>';
				}
			
			?>
	<br>
	</td>	
	</tr>
	</tbody>
</table>
	
<?php ob_end_flush();?>
</body>
</html>