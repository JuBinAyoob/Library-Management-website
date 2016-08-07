<html><head>
 <title>Leave Application Form</title>
<link rel="stylesheet" href="mine/leave/style/pure.css">
<style>
/*HTML CSS*/
html {
background-image: url(b1.jpg);
background-repeat: no-repeat;
}
/*PHP CSS*/
.container {
font-size: 28px;
font-family: sans-serif;
position: relative;
top: 50%;
left: 55%;
-moz-transform: translateX(-50%) translateY(-50%);
-webkit-transform: translateX(-50%) translateY(-50%);
transform: translateX(-50%) translateY(-50%);
}
/*This is the div cssDiv CSS*/
.box {
border-radius: 32px;
margin: auto;
background-color: white;
width: 550;
height: 350;
position: absolute;
top: 50%;
left: 50%;
-moz-transform: translateX(-50%) translateY(-50%);
-webkit-transform: translateX(-50%) translateY(-50%);
transform: translateX(-50%) translateY(-50%);
}
/*Body CSS*/
body {
overflow:hidden;
}
.button-success {
background: rgb(28, 184, 65); /* this is a green */
}

</style></head><body>






<div class="box">
<div class="container">


<?php 

/**
 * 
 * 
 * @category SMS
 * @copyright 2015
 * @description Request this page with get or post params
 * @param uid = Way2SMS Username
 * @param pwd = Way2SMS Password
 * @param phone = Number to send to. Multiple Numbers separated by comma (,). 
 * @param msg = Your Message ( Upto 140 Chars)
 */






include ('way2sms-api.php');



$conn = mysqli_connect("localhost","root","","library");





$num = 9539244320;
echo "message send to ".$num."<br>";



  $res =   sendWay2SMS("8129062800","JB123",$num, "your son/daughter has submitted  leave application for ");
  if(is_array($res)) echo $res[0]['result'] ? 'true' : 'false';
  else echo $res;
 


?>

	<br><br></p><a href="http://localhost/mine/chotest.php" class="button-success pure-button"> Home </a><br><br><br><br>
<a href="http://localhost/mine/chomessage.php" class="button-success pure-button"> back </a>	         
</div>
</div>
</body></html>
