<?php


include "update.php";
?>

<!DOCTYPE html>
<html>
  <head>

    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Waypoints in directions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        width: 100%;
        height: 100%;
      }
      #right-panel {
        margin: 20px;
        border-width: 2px;
        width: 100%;
        height: 400px;

        text-align: left;
        padding-top: 0;
      }
      #directions-panel {
        margin-top: 10px;
        background-color: #FFEE77;
        padding: 10px;
        overflow: scroll;
        height: 174px;
      }
    </style>
  </head>
  <body>

    <div class="container my-4">
    <div>
    <b>Start:</b>
    <select class="form-control" id="start">
      <option value="Mangalore Institute of Technology and Engineering, MITE">Mangalore Institute of Technology and Engineering, MITE, Badaga Mijar, Solapur -Mangalore Highway, Near Moodabidre, Mangalore, Karnataka 574225</option>
    <!--   <option value="SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka">SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka</option>
      <option value="SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka">SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka</option>
      <option value="SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka">SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka</option>
      <option value="SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka">SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka</option>
      <option value="SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka">SDM Institute of Technology, Dharmasthala Road, Near Siddhavana, Uijre, Karnataka</option> -->
    </select>
    <br>
    <b>Waypoints:</b> <br>
    <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br>
    <select  class="form-control" multiple id="waypoints">
      <option value="Ujire Circle, Uijre, Karnataka">Ujire Circle, Uijre, Karnataka</option>
      <option value="TB Cross Bus Stop, Mangalore - Dharmastala Highway, Karnataka">TB Cross Bus Stop, Mangalore - Dharmastala Highway, Karnataka</option>
      <option value="Laila Bus Stop, National Highway 234, Belthangady, Karnataka">Laila Bus Stop, National Highway 234, Belthangady, Karnataka</option>
      <option value="Laila Bridge, National Highway 73, Belthangady, Karnataka">Laila Bridge, National Highway 73, Belthangady, Karnataka</option>
      <option value="Belthangady Bus Stop, Belthangady, Karnataka">Belthangady Bus Stop, Belthangady, Karnataka</option>
      <option value="Church Road, Belthangady, Karnataka">Church Road, Belthangady, Karnataka</option>

    </select>
    <br>
    <b>End:</b>
    <select  class="form-control" id="end">
      <option value="Mangalore,Karnataka">Manglore</option>
     <!--  <option value="">Guruvayankere, Melanthabettu, Karnataka</option> -->
      <!--option value="San Francisco, CA">San Francisco, CA</option>
      <option value="Los Angeles, CA">Los Angeles, CA</option-->
    </select>
    <br>
      <input  class="btn btn-primary" type="submit" id="submit">
    </div>
    <div id="directions-panel"></div>
    </div>
    <div id="map"></div>
    </body>
    <script>
        var m=new Array(100);
        var markers=<?php


            $conn = mysqli_connect('localhost','root','','hump') or die('unable to connect');


            $location=mysqli_query($conn,"select * from `actual_data`    ");
            $a=array();

            while($row1= mysqli_fetch_assoc($location))
            {
                array_push($a, $row1);
            }
            echo json_encode($a);
            ?>;
    // var markers = [
    // {
    //     "title": 'SDM College Of Naturopathy And Yogic Sciences, Ujire, Karnataka',
    //     "lat": '12.9890189',
    //     "lng": '75.3381175',
    //     "description": 'SDM College'
    //
    // },
    // {
    //
    //     "title": 'SDM Degree College,road  Uijre, Karnataka',
    //     "lat": '12.9903128',
    //     "lng": '75.331283',
    //     "description": 'Ujire'
    // },
    // {
    //     "title": 'SDM Pre - University College, Ujire, Karnataka',
    //     "lat": ' 12.9912757',
    //     "lng": '75.75.3310039',
    //     "description": 'Ujire'
    // },
    // {
    //     "title": 'Benaka Health Centre, Dakshina Kannada, Karnataka',
    //     "lat": '12.996183',
    //     "lng": '75.3221508',
    //     "description": 'Ujire'
    // },
    // {
    //     "title": 'Laila,BUS STOP Halepete to Kuthrottu Road, Nada, Karnataka',
    //     "lat": '12.9941143',
    //     "lng": '75.2880132',
    //     "description": 'Laila'
    // }
    // ];
    var map ;
    var car;
      function initMap() {
          var directionsService = new google.maps.DirectionsService;
          var directionsDisplay = new google.maps.DirectionsRenderer;
          map = new google.maps.Map(document.getElementById('map'), {
              zoom: 10,

              center: {lat: 12.7761283, lng: 75.176463}
          });
          directionsDisplay.setMap(map);
          l = {text: "", color: "red", fontSize: "20px"};
          var icon = {
              url: 'hump.png',
              origin: new google.maps.Point(0, 0),
              labelOrigin: new google.maps.Point(20, 0)
          };


          for (var i = 0; i < markers.length; i++) {
              myLatlng = new google.maps.LatLng(markers[i].lat, markers[i].lng);
              m[i] = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  icon: icon,
                  title: "hump"
              });
              (function (marker) {
                  google.maps.event.addListener(marker, "click", function (e) {
                      //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                      // infoWindow.setContent("<div style = 'width:200px;min-height:40px'><a href='https://maps.google.com?q=" + data.lat + "," + data.lng + "'>Go to Place</a></div>");
                      infoWindow.open(map, marker);
                  });
              })(m[i]);


          }


         setInterval(function(){
          getLocation();
         },1000);
        document.getElementById('submit').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
      }

  $.noConflict();
jQuery( document ).ready(function( $ ) {
  // Code that uses jQuery's $ can follow here.
});

function updateM(position){
  var lat=position.latitude;
  var lng= position.longitude
    var newLatLng = new google.maps.LatLng(lat, lng);
    car.setPosition(newLatLng);
};


function getLocation() {

    jQuery.ajax({
cache: false,
    type: "GET",
  url: "getlloc.php",
  error: function(html)
{
  //alert(html.loc)

},
  success: function(html){
    data=html;
 var loc = data.split(",");

    var coords = {
        latitude: loc[0],
        longitude: loc[1]
    };

    showPosition(coords);
  }});
}
function showPosition(position) {

if(car==undefined)
{
var icon = {
    url: 'car.png',
    origin: new google.maps.Point(0, 0),
    labelOrigin: new google.maps.Point(20,0)
};

         myLatlng = new google.maps.LatLng(position.latitude, position.longitude);
        car = new google.maps.Marker({
                position: myLatlng,
                map: map,

                icon: icon,
                title: "data"
            });

}
else
updateM(position);

}


      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
          if (checkboxArray.options[i].selected) {
            waypts.push({
              location: checkboxArray[i].value,
              stopover: true
            });
          }
        }

        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('end').value,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
                summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCccic5O5iz_A-tZ4IhkCKe_LZHp0rHH0E&callback=initMap">
    </script>
  </body>
</html>
