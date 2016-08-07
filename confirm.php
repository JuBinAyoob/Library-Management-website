<html>
<head>
</head>
<body>
<?php
	if(isset($_GET['link']))
	{
		$link=$_GET['link'];
		$back=$_GET['back'];
		$bk=$_GET['bk'];
		
		//echo '<script type="text/javascript"> myFunction(); </script>';	
	}
?>

<script>
		//var bk = document.getElementById("bk").value;
		
		var lk = '<?php echo $link;?>';
		var back = '<?php echo $back;?>';
		var bk = '<?php echo $bk;?>';

		//alert(lk.charAt(6)+lk.charAt(0));
		if(lk.charAt(6) == "q")
			x = "Request the book  id '"+ bk +"'";
		else if(lk.charAt(6) == "n")
			x = "Delete Renew notification of userid: '"+ bk +"'";
		else if(lk.charAt(6) == "t")
			x = "Book Return id '"+ bk +"'";
		else if(lk.charAt(0) == "C")
			x = "Cancel Book Request of id '"+ bk +"'";
		else if(lk.charAt(0) == "R")
			x = "Do you want renew the book '"+ bk +"'";
		else if(lk.charAt(4) == "g")
		{
			x = "Give The Book with id '"+ bk +"'";
			lk=lk+bk;
		}
		else if(lk.charAt(0) == "A")
			x = "Cancel the accepted book request of '"+ bk +"'";
		else
			x = "Delete Message with subject: '"+ bk +"'";
		
		if (confirm( x ) == true) 
			window.location.href=lk;
		else
			window.location.href=back;

</script>
</body>
</html>