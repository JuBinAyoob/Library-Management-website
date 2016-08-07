<?php
	require 'DBconnect.php';
	$tmpusrid=$_SESSION['ID'];
	$ID=$_SESSION['ID'];
	$ID=substr($ID,0,1);
	if($ID=='A')
		$sql="SELECT DISTINCT subject FROM messages WHERE  too='admin' and status_admin=1";
	else
		$sql="SELECT DISTINCT subject FROM messages WHERE  too='$tmpusrid' and status_user=1";
	
	$result=mysqli_query($con,$sql);

	if(! $result ) 
		die('Could not get data: ' . mysqli_error($con));
	else
		$count=mysqli_num_rows($result);
	
	if($count>0)
	{
?>
		<div id="noti_Container" style=" width: 30px; height: 19px; text-align: center; margin-left: auto; margin-right: auto;">
		<img src="images/message.png" alt="notification icon" style="width: 100%; height: 100%; " />
		<div class="noti_bubble"><?php echo $count; ?></div>
		</div>
<?php
	}
	else
	{
?>
		<div id="noti_Container" style=" width: 30px; height: 19px; text-align: center; margin-left: auto; margin-right: auto;">
		<img src="images/message.png" alt="notification icon" style="width: 100%; height: 100%; " />
		</div>
<?php		
	}
?>
