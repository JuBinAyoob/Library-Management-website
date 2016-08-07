<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<?php ob_start();
session_start();
if(!isset($_SESSION['myusername'])){
header("location:Adminlogin.php");
}
require 'DBconnect.php';
?>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>ADD BOOKS</title>

<link href="CSS/bootstrap.css" rel="stylesheet" />
<link href="CSS/bootstrap-responsive.css" rel="stylesheet" />
<link href="CSS/Menubar.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="CSS/fbstyle.css">

</head>
<body style="color: rgb(0, 0, 0); background-color: rgb(195, 223, 239);" alink="#000099" link="#000099" vlink="#990099">
<ul>
<li><a class="nonactive" href="AdminPage.php">Home</a></li>
<li><a href="AdminNotification.php"><?php require 'notificationstyle.php'; ?></a></li>
<li><a href="Message.php"><?php require 'messagestyle.php'; ?></a></li>
<li><a href="ADDuser.php">ADD User</a></li>
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
		
		
		<div class="container" style=" width:50%; height:100%; " >
		<form class="form-horizontal" name="addbooks" method="post" action="Addbooks.php" enctype="multipart/form-data">
			<fieldset>
			<legend>ADD BOOKS</legend>
			<h4 style="color: rgb(155, 0, 0);">required fields(*)</h4>
			<div class="control-group">
				<label class="control-label">Book's ID*:</label>
				<div class="controls">
					<input name="book_id" id="book_id" type="number" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Book's name*:</label>
				<div class="controls">
					<input name="booksname" id="booksname" type="text" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Author*:</label>
				<div class="controls">
					<input name="author" id="author" type="text" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Publication:</label>
				<div class="controls">
					<input name="publication" id="publication" type="text" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Edition:</label>
				<div class="controls">
					<input name="edition" id="edition" type="text" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Price*:</label>
				<div class="controls">
					<input name="price" id="price" type="number" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Department:</label>
				<div class="controls">
					<select name="department" id="department" >
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
				<label class="control-label">Subject:</label>
				<div class="controls">
					<input name="subject" id="subject" type="text" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Book for sem:</label>
				<div class="controls">
					<select name="booksem" id="booksem" >
					<option value=""></option>
					<option value="S1">S1</option>
					<option value="S2">S2</option>
					<option value="S3">S3</option>
					<option value="S4">S4</option>
					<option value="S5">S5</option>
					<option value="S6">S6</option>
					<option value="S7">S7</option>
					<option value="S8">S8</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">choose book pic:</label>
				<div class="controls">
					<input type="file" name="image" />
				</div>
			</div>
			
<?php 

	if(isset($_POST['book_id'])&&isset($_POST['booksname'])&&isset($_POST['author'])&&isset($_POST['price']))
	{
		require 'DBconnect.php';
		//$tbl_name="books"; // Table name

		$book_id=$_POST['book_id'];
		$booksname=$_POST['booksname'];
		$author=$_POST['author'];
		$publication=$_POST['publication'];
		$edition=$_POST['edition'];
		$price=$_POST['price'];
		$subject=$_POST['subject'];
		$department=$_POST['department'];
		$booksem=$_POST['booksem'];
		
		
		if(!(empty($department)&&!empty($booksem)))
			$book_id=$department.$booksem.$book_id;
		
		if(!empty($department)&&!empty($booksem))
			$main_id=substr($book_id,0,8);
		else if(!empty($department)&&empty($booksem))
			$main_id=substr($book_id,0,6);
		else
			$main_id=substr($book_id,0,3);
		
		
		$sql2="SELECT * FROM books WHERE subid='$book_id'";
		$result2=mysqli_query($con,$sql2);
			
		if(!$result2) 
			die('Could not get data: ' . mysqli_error());
				
		$count=mysqli_num_rows($result2);
			
		if($count==0)
		{
			
			$sql2="SELECT * FROM books WHERE mainid='$main_id'";
			$result2=mysqli_query($con,$sql2);
			
			if(!$result2) 
				die('Could not get data: ' . mysqli_error());
				
			$count=mysqli_num_rows($result2);
			
			if($count==0)
			{
				
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
	  
					$file_name=$main_id.".jpg";
			
					if(empty($errors)==true)
						move_uploaded_file($file_tmp,"bookpics/".$file_name);
					else
					{
						print_r($errors);
				
						echo "<br>failed to upload the image file...";
					}
				
				}
			}
			else
				$flag=1;
		
			if(isset($flag)||isset($errors)&&empty($errors))
			{
				$sql = "INSERT INTO books ". "(subid,mainid,name,author,publication,edition,
					price,department,subject,sem) ". "VALUES('$book_id','$main_id','$booksname','$author','$publication','$edition','$price','$department','$subject','$booksem')";
				$result=mysqli_query($con,$sql);

				if(!$result) 
					die('Could not get data: ' . mysqli_error());
				else
				{
					$sql2="SELECT * FROM bookrequests WHERE mainid='$main_id'";
					$result2=mysqli_query($con,$sql2);
			
					if(!$result2) 
						die('Could not get data: ' . mysqli_error());
				
					$count=mysqli_num_rows($result2);
			
					if($count==0)
					{	
						$sql3 = "INSERT INTO bookrequests ". "(mainid) ". "VALUES('$main_id')";
						$result3=mysqli_query($con,$sql3);

						if(!$result3) 
							die('Could not get data: ' . mysqli_error());
					}
					else
					{	
						$sql3 = "UPDATE bookrequests SET total_books=total_books+1, available_books=available_books+1 WHERE mainid='$main_id'";
						$result3=mysqli_query($con,$sql3);

						if(!$result3) 
							die('Could not get data: ' . mysqli_error($con));
					}
			
			
					echo '<span style="font-family: Tahoma; color: red;">Book ID:'.$book_id.' is added to DB</span>';

				}
			}
		}
		else
			echo '<span style="font-family: Tahoma; color: red;">The book with same sub id is existed... There for enter new subid...</span>';
	}
?>
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" name="Submit" class="btn btn-success">Add Book</button>
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