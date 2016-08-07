<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">
</head>

<body>
<?php
	require 'DBconnect.php';
	$tmpusrid=$_SESSION['ID'];
	$tmpid=substr($tmpusrid,0,1);
	if($tmpid=='A')
		$sql="SELECT * FROM notification WHERE userid='admin' and status=1";
	else
		$sql="SELECT * FROM notification WHERE userid='$tmpusrid' and status=1";
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);

	if($count>0)
	{
?>
		<div id="noti_Container" style=" width: 30px; height: 19px; text-align: center; margin-left: auto; margin-right: auto;">
		<img src="images/notification_icon2.png" alt="notification icon" style="width: 100%; height: 100%; " />
		<div class="noti_bubble"><?php echo $count; ?></div>
		</div>
<?php
	}
	else
	{
?>
		<div id="noti_Container" style=" width: 30px; height: 19px; text-align: center; margin-left: auto; margin-right: auto;">
		<img src="images/notification_icon2.png" alt="notification icon" style="width: 100%; height: 100%; " />
		</div>
<?php		
	}
?>
</body>
</html>