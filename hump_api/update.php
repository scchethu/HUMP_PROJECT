<?php

$lat=$_GET['lat'];
$lng=$_GET['lng'];

if(isset($lat))
file_put_contents("loc.txt","$lat,$lng");



?>