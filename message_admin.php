<?php ob_start();
	session_start();
	if(!isset($_SESSION['myusername']))
		header("location:index.html");

	$ID=$_SESSION['ID'];
	$ID=substr($ID,0,1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message Admin</title>

<link rel="stylesheet" type="text/css" href="msg/jqtransformplugin/jqtransform.css" />
<link rel="stylesheet" type="text/css" href="msg/demo.css" />



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="msg/jqtransformplugin/jquery.jqtransform.js"></script>


<script type="text/javascript" src="msg/script.js"></script>

</head>

<body>

<div id="main-container">

	<div id="form-container">
    <h1>Message Librarian</h1>
    <h2>If u have any complaints... or to suggest new books in library... Contact Us...</h2>
    
    <form id="contact-form" name="contact-form" method="post" action="message_admin.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td width="15%"><label for="subject">Subject</label></td>
          <td width="85%"><input type="text"  name="subject" id="subject" placeholder="Enter Subject" required ></td>
        </tr>
        <tr>
          <td valign="top"><label for="message">Message</label></td>
          <td><textarea name="message" id="message" cols="35" rows="5" placeholder="Enter Your Message" required ></textarea></td>
         
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="2"><input type="submit" name="contact" id="button" value="Submit" />
          <input type="reset" name="button2" id="button2" value="Reset" />
          
			</td>
        </tr>
      </table>
      </form>
    </div>
	<div class="tutorial-info">	
    Go to home page <a href="<?php if($ID=='T') echo 'StaffPage.php'; else echo 'StudentPage.php';?>">by clicking this link...</a>
	
<?php 
	if(isset($_POST['contact']))
	{
		$subject=$_POST['subject'];
		$message=$_POST['message'];
		
		$to="Admin";
		$from=$_SESSION['ID'];
		$fromdet=$_SESSION['myusername'].'('.$_SESSION['ID'].','.$_SESSION['department'].')';
		
		require 'DBconnect.php';
		$sql="CALL Message_Send('$from','$fromdet','$to','$subject','$message',1)";
		
		$result=mysqli_query($con,$sql);
		if(!$result)
			die("Could not update data".mysqli_error($con));
		else
			echo '<br><br><br><br>Message SEND Successfully...';
			
	}
?>

</div>

</body>
</html>
