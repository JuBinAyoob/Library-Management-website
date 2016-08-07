<?php ob_start(); session_start(); session_destroy(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Staff Login</title>

</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<table style="background-color: yellow; text-align: left; margin-left: auto; margin-right: auto; height: 100%; width: 85%;" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="width: 800px; height: 33px; white-space: nowrap; background-color: white;">
<a href="http//:simat.ac.in"><img style="border: 0px solid ; width: 100%; height: 108px;" alt="SIMAT, Vavanoor" src="images/site_title_2.jpg"></a>
<hr>
<table style="width: 100%; text-align: left; margin-left: auto; margin-right: 0px;" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<img style="width: 273px; height: 150px;" alt="Staff Login" src="images/staff_login.jpg" align="middle">
</td>
<td>
<marquee behavior="alternate">
<h1><span style=" color: rgb(153, 0, 0);font-family: Jokerman;">Page... for.... </span></h1>
</marquee>
</td>
<td>
<a href="index.html" ><img src="images/library-management-system-by-mlmAGE.com.jpg" alt="" style="width: 400px; height: 150px;" align="middle"></a>
</td>
</tr>
</tbody>
</table>
<hr style="width: 100%; height: 2px;">
<br>
<p>&nbsp;<span style="font-weight: bold; text-decoration: underline;">Rules
And Regulations For Staffs...</span></p>
<p></p>
<p><img src="images/staff-login_button.png" alt="" style="width: 320px; height: 90px; float: right;"></p>
<ul>
<li>You can only take the book, Which is assigned for
your subjects....</li>
</ul>
<p>&nbsp;</p>
<br>
<br>
<table align="right" bgcolor="#cccccc" border="0" cellpadding="0" cellspacing="0" width="300">
<tbody>
<tr>
<form name="form1" method="post" action="Stafflogin.php">
<td>
<table bgcolor="#ffffff" border="0" cellpadding="3" cellspacing="1" width="100%">
<tbody>
<tr>
<td colspan="3"><strong>Staff
Login </strong></td>
</tr>
<tr>
<td width="78">ID</td>
<td width="6">:</td>
<td width="294"><input name="myuserid" id="myuserid" type="text" required></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="mypassword" id="mypassword" type="password" required></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
<?php
if(isset($_POST['myuserid'])&&isset($_POST['mypassword']))
{
	session_start();
	require 'DBconnect.php';
	$tbl_name="users"; // Table name
 
	// username and password sent from form
	$myuserid=$_POST['myuserid'];
	$mypassword=$_POST['mypassword'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$myuserid = stripslashes($myuserid);
	$mypassword = stripslashes($mypassword);
	$myuserid = mysqli_real_escape_string($con,$myuserid);
	$mypassword = mysqli_real_escape_string($con,$mypassword);

	$sql="SELECT * FROM $tbl_name WHERE ID='$myuserid' and password='$mypassword'";
	$result=mysqli_query($con,$sql);

	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);	
	
	// If result matched $myuserid and $mypassword, table row must be 1 row
	if($count==1&&substr($myuserid,0,1)=='T')
	{
		$sql2="SELECT username FROM $tbl_name WHERE ID='$myuserid' and password='$mypassword'";
		$retval = mysqli_query($con,$sql2);
   
		if(! $retval ) 
			die('Could not get data: ' . mysqli_error());
		else
			$row = mysqli_fetch_assoc($retval);
			
		$_SESSION['myusername']=$row['username'];
		$_SESSION['ID']=$myuserid;
		header("location:StaffPage.php");
	}
	else 
		echo "Wrong Username or Password";
	
}

	
?>
</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input name="Submit" value="Login" type="submit"></td>
</tr>
</tbody>
</table>
</td>
</form>
</tr>
</tbody>
</table>
<center>
<h3><span style=" color: violet;font-family: Jokerman;">If u have complaint to specify... <br>or to add new books in library...  Contact Librarian... From ur account...</span></h3>
</center>
</td>
</tr>
</tbody>
</table>
<br>
</body></html>

<?php ob_end_flush();?>