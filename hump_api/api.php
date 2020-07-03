<?php


define("FIREBASE_API_KEY","AAAAN7UpbgQ:APA91bHywJ-RP4dnOgH016IUvZsWJ2YZL3CkCuv-7oWSJpOWIMWinU41BFNLnRDBPNo40vSfJTrQAQQdeo2UjNdDnKUCw2ai_A_XTsIisWmHwSBOuy2PCBFerVvHnP8oxKtHdx3KvroM");








     function sendPushNotification($fields) {

        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }
function sendMsg($msg)
{
$fields =
        ' {
    "to": "/topics/hump",
    "notification": {
      "title": "Hump detection",
      "body": "'.$msg.'",
      "mutable_content": true,
      "sound": "Tri-tone"
      },

   "data": {
    "msg": "35.5PA3.32PD4.74PF21.3PH1.49PS4.33PS29.43PN"
      }
}';
sendPushNotification(json_decode($fields));

}

$_lat=$_GET['lat'];
$_lng=$_GET['lng'];

$dist=$_GET['dist'];

$con=mysqli_connect("localhost","root","","hump");
if(!$con)
echo "db error";


$q="select * from actual_data";

$r=mysqli_query($con,$q);


while($row=mysqli_fetch_array($r)){

$lat=$row['lat'];
$lng=$row['lng'];

if(($dd=distanceCalculation($_lat,$_lng,$lat,$lng))<=0.5){

echo "hump will came at $dd meter distance\n";

sendMsg("hump will came at $dd km distance");

}
else{
	echo "no hump detected yet $dd\n";
}

if($row['type']=="Hump"){


if($dist<$row['th']){


	echo "hump detected\n";
sendMsg("hump detected");
}
else
	echo "hump not detected\n";

}else{


if($dist>$row['th']){


	echo "pothol detected\n";
sendMsg("pothol  detected");
}
else
{
echo "pathol no detected\n";
}
}





}









function distanceCalculation($lat1, $lon1, $lat2, $lon2) {
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lon1 *= $pi80;
    $lat2 *= $pi80;
    $lon2 *= $pi80;
    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;
//echo ' '.$km;
    return $km;
}
?>
