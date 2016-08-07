	<?php
    $key=$_GET['key'];
    $array = array();
    $con=mysqli_connect("localhost","root","");
    $db=mysqli_select_db($con,"library");
    $query=mysqli_query($con,"select * from books where name LIKE '%{$key}%' or mainid LIKE '%{$key}%' ");
    while($row=mysqli_fetch_assoc($query))
    {
      $array[] = $row['name'];
    }
    echo json_encode($array);
?>
