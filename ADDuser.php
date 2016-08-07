<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<?php ob_start();
session_start();
if(!isset($_SESSION['myusername'])){
header("location:Adminlogin.php");
}
require 'DBconnect.php';
?>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>ADD USER</title>

<link href="CSS/bootstrap.css" rel="stylesheet" />
<link href="CSS/bootstrap-responsive.css" rel="stylesheet" />
<link href="CSS/Menubar.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>

</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<ul>
<li><a class="nonactive" href="AdminPage.php">Home</a></li>
<li><a href="AdminNotification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<li><a href="ADDbooks.php">ADD Books</a></li>
<ul style="float: right; list-style-type: none;">
<li><a class="nonactive" href="rules.html">Rules
of library</a></li>
<li><a href="Accountsetting.php">Account
Settings</a></li>
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
		
		<br>
		<div class="container" style=" width: 50%; height:100%; " >
		<form class="form-horizontal" name="adduser" method="post" action="Adduser.php" enctype="multipart/form-data">
			<fieldset>
			<legend>ADD USER</legend>
			<h4 style="color: rgb(155, 0, 0);">required fields(*)</h4>
			<div class="control-group">
				<label class="control-label">User's name*:</label>
				<div class="controls">
					<input name="studentsname" id="studentsname" type="text" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">ID*:</label>
				<div class="controls">
					<input name="studentid" id="studentid" type="text" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Department*:</label>
				<div class="controls">
					<select name="department" id="department" required >
					<option value=""></option>
					<option value="CSE">CSE</option>
					<option value="ECE">ECE</option>
					<option value="EEE">EEE</option>
					<option value="MEC">MEC</option>
					<option value="CVE">CVE</option>
					</select>
				</div>
			</div>
			
			
			
			<div class="control-group">
				<label class="control-label">Date of Admission*:</label>
				<div class="controls">
					<input name="admissiondate" id="datepicker" type="text" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">University RegNo:</label>
				<div class="controls">
					<input name="universityregno" id="universityregno" type="text" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Email:</label>
				<div class="controls">
					<input name="email" id="email" type="email" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Mobile No:</label>
				<div class="controls">
					<input name="mobno" id="mobno" type="number" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">choose user pic*:</label>
				<div class="controls">
					<input type="file" name="image" required/>
				</div>
			</div>

		<?php 

		if(isset($_POST['studentsname'])&&isset($_POST['studentid'])&&isset($_POST['department'])&&isset($_POST['admissiondate']))
		{
			require 'DBconnect.php';
			//$tbl_name="books"; // Table name

			$studentsname=$_POST['studentsname'];
			$studentid=$_POST['studentid'];
			$department=$_POST['department'];
			$admissiondate=$_POST['admissiondate'];
			$universityregno=$_POST['universityregno'];
			$email=$_POST['email'];
			$mobno=$_POST['mobno'];
			
			if(isset($_FILES['image']))
			{
				$errors= array();
				//$file_name = $_FILES['image']['name'];
				$file_size =$_FILES['image']['size'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$file_type=$_FILES['image']['type'];
				@$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
				$expensions= array("jpeg","jpg","png");
      
				if(in_array($file_ext,$expensions)=== false)
					$errors[]="extension not allowed, please choose a JPEG or PNG file.";
      
				if($file_size > 2097152)
					$errors[]='File size must be excately 2 MB';
				
				$file_name=$studentid.".jpg";
      
				if(empty($errors)==true)
					move_uploaded_file($file_tmp,"userpics/".$file_name);
				else
				{
					print_r($errors);
				
					echo "<br>failed to upload the image file...";
				}
				
			}
			
			if(isset($errors)&&empty($errors))
			{
		
				$sql = "INSERT INTO staffandstudent ". "(ID,username,department,admissiondate,universityno,email,mobno) ". "VALUES('$studentid','$studentsname','$department','$admissiondate','$universityregno','$email','$mobno')";
				$result=mysqli_query($con,$sql);

				if(!$result) 
					echo 'Same Type of USERID is used before:    ' . mysqli_error($con);
				else
				{
					$sql2 = "INSERT INTO users ". "(ID,username,password) ". "VALUES('$studentid','$studentsname','$studentid')";
					$result2=mysqli_query($con,$sql2);

					$sql3 = "INSERT INTO transaction ". "(ID) ". "VALUES('$studentid')";
					$result3=mysqli_query($con,$sql3);
					if(!$result2 || !$result3) 
						die('Could not get data: ' . mysqli_error());
					else
						echo '<span style="font-family: Tahoma; color: red;">User ID:'.$studentid.' is added to DB</span>';
				}
			}
		}

		?>
		<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" name="Submit" class="btn btn-success">Add User</button>
				</div>
			</div>
		</fieldset>
	</form>
	</div>
		
		<br>
		</td>
	</tr>
</tbody>
</table>



<?php ob_end_flush();?>
</body></html>