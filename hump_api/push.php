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

$fields =
        ' {
    "to": "/topics/hump",
    "notification": {
      "title": "Hump detection",
      "body": "Male gender detected",
      "mutable_content": true,
      "sound": "Tri-tone"
      },

   "data": {
    "msg": "35.5PA3.32PD4.74PF21.3PH1.49PS4.33PS29.43PN"
      }
}';
echo sendPushNotification(json_decode($fields));

?>