
<!doctype html>
<html>
<head>
    <title>GoPool</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Weather</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!--     Google Places API -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>


    <style type="text/css">
        @font-face {
            font-family: LeagueGothic;
            src: url('fonts/league_gothic/league_gothic-webfont.eot');
            src: url('fonts/league_gothic/league_gothic-webfont.eot?#iefix') format('embedded-opentype'),
            url('fonts/league_gothic/league_gothic-webfont.woff') format('woff'),
            url('fonts/league_gothic/league_gothic-webfont.ttf') format('truetype'),
            url('fonts/league_gothic/league_gothic-webfont.svg#LeagueGothicRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        /* enable absolute positioning */
        .inner-addon {
            position: relative;
        }
        body {

        }
        /* style icon */
        .inner-addon .glyphicon {
            position: absolute;
            padding: 15px;
            padding-right: 25px;
            pointer-events: none;
        }
        /* align icon */
        .left-addon .glyphicon  { left:  2px;}
        .right-addon .glyphicon { right: 2px;}
        /* add padding  */
        .left-addon input  { padding-left:  40px; }
        .right-addon input { padding-right: 40px; }
        .center {text-align: center;}
        #user {padding: 5px;}
        #pass {padding: 5px; padding-bottom: 10px;}
        #signup {
            float: left;
            margin-left: 1.7%;
        }
        #login {
            float: right;
            margin-right: 1.7%;
        }
        #form {
            margin-top: 300px;
        }
        #drop {
            margin-left: 5px;
        }
        #title {
            font-family: LeagueGothic;
        }
    </style>
</head>
<body>
<?php
require 'base.php';
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $sql = "SELECT * FROM User WHERE email= :email AND password= :password";
        $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $st->execute(array(':email' => $email, ':password' => $password));
        if ($st->rowCount()) {
            $rows = $st->fetchAll();
            $_SESSION["email"] = $email;
            header('Location: search.php');
        } else {
            print "Invalid username and/or password";
        }
    } catch (PDOException $e) {
        print $e;
    }
}
else if (isset($_POST["r_email"]) && isset($_POST["r_password"]) && isset($_POST["university"]) && isset($_POST["major"])
    && isset($_POST["first_name"]) && isset($_POST["last_name"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['r_email'];
    $password = $_POST['r_password'];
    $university = $_POST['university'];
    $major = $_POST['major'];

    $sql = "INSERT INTO User (first_name, last_name, email, password, university, major)
        VALUES (:first_name, :last_name, :email, :password, :university,
        :major);";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $st->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':password' => $password,
            ':university' => $university, ':major' => $major));
    } catch (PDOException $e) {
        print $e;
    }
    if ($st->rowCount()) {
        header('Location: index.php');
    } else {
        print "Invalid parameter";
    }
}
?>
<div class="container">
    <h1 id="title"><b>GoPool</b> <small>Go anywhere. Real cheap.</small></h1>
    <form class="form-horizontal" method="post">
        <div class="inner-addon left-addon" id="user">
            <i class="glyphicon glyphicon-user"></i>
            <input type="text" class="form-control" placeholder = "Email" id="email" name="email"/>
        </div>
        <div class="inner-addon left-addon" id="pass">
            <i class="glyphicon glyphicon-lock"></i>
            <input type="password" class="form-control" placeholder = "Password" id="password" name="password"/>
        </div>
        <div class="form-group center inline">
            <div>
                <button type="button" class="btn" data-toggle="modal" data-target = "#myModal" id="signup"><b>Don't have an account? Click here.</b></button>
            </div>
            <div>
                <button type="submit" class="btn btn-success" id="login"><b>Login</b></button>
            </div>
        </div>
    </form>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Get started with SaltPool!</h4>
            </div>
            <div class="modal-body">
                <p>Enter your basic information and start riding.</p>

                <form class="form-horizontal" method="post">
                    <div class="inner-addon left-addon" id="user">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" class="form-control" name="first_name" placeholder = "Enter your First Name"/>
                    </div>
                    <div class="inner-addon left-addon" id="user">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" class="form-control" name="last_name" placeholder = "Enter your Last Name"/>
                    </div>
                    <div class="inner-addon left-addon" id="user">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="email" class="form-control" name="r_email" placeholder = "Enter your email"/>
                    </div>
                    <div class="inner-addon left-addon" id="pass">
                        <i class="glyphicon glyphicon-lock"></i>
                        <input type="password" class="form-control" name="r_password" placeholder = "Choose a password"/>
                    </div>
                    <div class="inner-addon left-addon" id="pass">
                        <i class="glyphicon glyphicon-lock"></i>
                        <input type="password" class="form-control" placeholder = "Confirm password"/>
                    </div>
                    <div class="inner-addon left-addon" id="pass">
                        <i class="glyphicon glyphicon-education"></i>
                        <input type="text" class="form-control" name="university" placeholder = "College/University"/>
                    </div>
                    <select name="major" class="browser-default">
                        <option disabled selected value="">Major</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Liberal Arts">Liberal Arts</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Sciences">Sciences</option>
                    </select>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submit"><b>Register</b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.

    function initMap() {

      // Try HTML5 geolocation.
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          console.log(pos);
          $('#login').click(function() {
            url = 'http://localhost/search.html?lat=' + pos.lat + '&lng=' + pos.lng;
                      document.location.href = url;
          })
        }, function() {
          handleLocationError(1);
        });
      } else {
        // Browser doesn't support Geolocation
        handleLocationError(2);
      }
    }

    function handleLocationError(num) {
      if(num === 1) {
          alert("Could not locate you!");
      } else {
          alert("Your browser does not support Geolocation!");
      }
    }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcwmPkIk7GjzLJ-DcOsI9bjbKnULoqPEc&signed_in=true&callback=initMap"
        async defer>
    </script>
</body>
</html>