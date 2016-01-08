<?php
require 'base.php';
if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header('Location: index.php');
} 
?>
<!DOCTYPE html>
<html>
<head>
    <title>GoPool</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html, body{
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #4f585d;
        }
        #panel {
            position: absolute;
            top: 5px;
            left: 50%;
            margin-left: -180px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            background-color: #4f585d;
        }
        #panel, .panel {
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        #panel select, #panel input, .panel select, .panel input {
            font-size: 15px;
        }

        #panel select, .panel select {
            width: 100%;
        }
        #panel i, .panel i {
            font-size: 12px;
        }
        #directions-panel {
            height: 100%;
            width: 50%;
            float: left;
            overflow: auto;
            margin-top: 10px;
        }
        #map-canvas {
            background-color: #4f585d;
            margin-top: 40px;
            border-top: rgba(109, 118, 123, 0.2) 20px solid;
            border-bottom: rgba(109, 118, 123, 0.2) 20px solid;
            height:50%;
        }
        #drivers {
            float: left;
            margin-top: 10px;
            border: 1px lightslategray;
            background-color: lightslategrey;
            margin-left: 50px;
        }
    </style>

    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.5.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script type="text/javascript">

        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();

        // qu = address.replace(/\b\#\w+/g, ''); 

            var QueryString = function () {
                // This function is anonymous, is executed immediately and 
                // the return value is assigned to QueryString!
                var query_string = {};
                var withouthashtags = (window.location.href);
                withouthashtags = withouthashtags.replace(/\b\#\w+/g, ''); 
                if(withouthashtags != window.location.href) {
                    window.location.href = withouthashtags;
                }
                var query = window.location.search.substring(1);
                var vars = query.split("&");
                for (var i=0;i<vars.length;i++) {
                    var pair = vars[i].split("=");
                        // If first entry with this name
                    if (typeof query_string[pair[0]] === "undefined") {
                    query_string[pair[0]] = decodeURIComponent(pair[1]);
                        // If second entry with this name
                    } else if (typeof query_string[pair[0]] === "string") {
                    var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                    query_string[pair[0]] = arr;
                        // If third or later entry with this name
                    } else {
                    query_string[pair[0]].push(decodeURIComponent(pair[1]));
                    }
                } 
                    return query_string;
            }();

        function initialize() {
            // $("#map-canvas").hide();
            directionsDisplay = new google.maps.DirectionsRenderer();
            console.log(QueryString.lat + QueryString.lng);
            var mapOptions = {
                zoom: 3,
                center: new google.maps.LatLng(QueryString.lat, QueryString.lng) //INPUT CURRENT USER LOCATION HERE
            };
            var map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(document.getElementById('directions-panel'));

            var control = document.getElementById('control');
            control.style.display = 'block';
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);
        }
        function calcRoute() {
            // window.onload = function () {
            var url = document.location.href,
                params = url.split('?')[1].split('&'),
                data = {}, tmp;
            for (var i = 0, l = params.length; i < l; i++) {
                tmp = params[i].split('=');
                data[tmp[0]] = tmp[1];
            }
            var address = data.name;
            //UnitedStates backwards is setatSdetinU
            var temp = address.length - 1;
            for (var i = temp; i >= 0; i--) {
                if (address.charAt(i) == ',') {break;}
            };
            if (address.substring(i,address.length) == ',UnitedStates') {
                address = address.substring(0,i);
            };
            address = address.replace(/ /g,'');
            address = address.replace(/%20/g,'');
            console.log(address);
            var start = new google.maps.LatLng(QueryString.lat, QueryString.lng)
            // var end = address
            var end = address
            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING,
                provideRouteAlternatives: true
            };
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });
        }
        window.onload = function () { calcRoute() };
        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
</head>
<body>
<!--     <button id="press">Press</button> -->
<div id="map-canvas"></div>
<div id="directions-panel" class="panel"></div>
<div id="drivers">
    <?php
    if (isset($_POST["driver"])) {
        $ride = $_POST["result"];
        $driver_email = $ride[0];
        $rider_email = $_SESSION["email"];
        $origin = $ride[2];
        $destination = $ride[1];
        date_default_timezone_set('America/New_York');
        $request_time = date_default_timezone_get();

        $sql = "INSERT INTO Current_Rides
                            VALUES (:destination, :origin, :request_time, :rider_email, :driver_email, False);";
        $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $st->execute(array(':destination' => $destination, ':origin' => $origin, ':request_time' => $request_time,
            ':rider_email' => $rider_email, ':driver_email' => $driver_email));
        if ($st->rowCount()) {
            print 'Ride Successfully Requested';
        } else {
            print 'Error';
        }
    }
    ?>
    <form method="post">
        <select name="driver" class="browser-default">
            <option disabled selected value="">Driver</option>
            <?php
                $destination = $_GET["name"];
                $sql = "SELECT *
                        FROM Available_Rides JOIN User
                        WHERE destination = :destination AND driver_email = User.email;";
                $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $st->execute(array(':destination' => $destination));
                $rides = $st->fetchAll();
                foreach ($rides as $ride) {
                    $postvalue = array($ride["driver_email"], $ride["destination"], $ride["origin"]);
                    print "<option>" . $ride["first_name"] . " " . $ride["last_name"] . " - " .
                        $ride["destination"] . "</option>";
                    foreach($postvalue as $value)
                    {
                        echo '<input type="hidden" name="result[]" value="'. $value. '">';
                    }
                }
            ?>
        </select>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="submit"><b>Request Ride</b></button>
        </div>
    </form>
    <ul>

    </ul>
</div>
<script type="text/javascript">
    $("#test").hide();
    $("#press").click(function() {
        calcRoute();
    });
</script>
</body>
</html>