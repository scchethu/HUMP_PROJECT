<?php

if($_POST){
	
$lat=$_POST['lat'];
$lng=$_POST['lng'];
$type=$_POST['type'];
$th=$_POST['th'];

$con=mysqli_connect("localhost","root","","hump");

if(!$con)
echo "db error";

$q="INSERT INTO `actual_data` (`lat`, `lng`, `type`, `th`) VALUES ('$lat', '$lng', '$type', '$th');";




$r=mysqli_query($con,$q);


if($r)

{
	echo "<script>alert('Data added');</script";
}
}





?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<div class="p-3 bg-primary text-light">Hump and pathole detection</div>

	<div class="card mt-5">
		<div class="card-header">Add Location</div>
		<div class="card-body">
			<form class="form-inline" action="" method="post">
				<input type="text" class="form-control mr-sm-2" name="lat" placeholder="latitude">
			    <input type="text" class="form-control mr-sm-2" name="lng" placeholder="longituide">
			    <select class="form-control mr-sm-2" name="type">
			    	<option>Hump</option>
			    	<option>Pathole</option>
			    </select>
			    <input type="number" class="form-control mr-sm-2" name="th" placeholder="threashold level">
			    <div class="form-group">
			    	
			    	<input type="submit" name="" class="btn btn-primary" value="Add">
			    </div>
			</form>

		</div>
	</div>
</div>

</body>
</html>

