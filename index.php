<!doctype html>
<html>
<head>
    <title>Impala</title>
	<link rel="shortcut icon" href="./Assets/Images/impala.gif"> 

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Weather</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!--Load Angular-->
	<script src="http://code.angularjs.org/1.2.6/angular.js"></script> 
	
	<!--Form validation script-->
	<script src="formvalidation.js"></script>

    <style type="text/css">
        body {
            background-color: #101010 ;
        }

        /* enable absolute positioning */
        .inner-addon {
            position: relative;
        }
        #email {
            border-radius: 0px;
            background-color: #404040;
            border: none;
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
            line-height: 30px;
        }
        #password {
            border-radius: 0px;
            background-color: #404040;
            border: none;
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
        }
        #email, textarea {
            color:white;
            padding-top: 9px;
        }
        #password, textarea {
            color:white;
            padding-top: 9px;
        }
        .nobord {
            border-radius: 0px;
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
        }
        button {
            border-radius: 0px;
        }
        /* style icon */
        .inner-addon .glyphicon {
            position: absolute;
            padding: 15px;
            padding-right: 25px;
            pointer-events: none;
            color: #B0B0B0 ;
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
            border-radius: 0px;
            background-color: #B0B0B0;
                  font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
                  font-weight: none;
        }
        #signup:hover{
            background-color: gray;
        }
        #login {
            float: right;
            margin-right: 1.7%;
            border-radius: 0px;
            background-color: #0099CC;
            color: white;
                  font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
        }
        #login:hover {
            background-color: #00BFFE;
        }
        #form {
            margin-top: 300px;
        }
        #drop {
            margin-left: 5px;
        }
        #title {
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
            color: #B0B0B0;
            margin-top: 120px;
            padding-bottom: 10px;
            border-bottom: 1px solid #0099CC;
        }
        .modal-content  {
            -webkit-border-radius: 0px !important;
            -moz-border-radius: 0px !important;
            border-radius: 0px !important; 
        }
        .majordrop {
            height: 30px;
            margin-left: 5px;
        }
        #submit {
            background-color: #0099CC;
            color: white;
        }
        #submit:hover{
            background-color:#00BFFE; 
        }
        .inv {
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
        }
        .customalert {
            border-radius: 0px;
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Geneva, Verdana, sans-serif;
            opacity: 0;
            background-color: #F53D3D;
            color: white;
            border: none;
            margin-top: 20px;
        }
        .bold {
            font-weight: bold;
        }
        #impala {
            float: right;
            position: relative;
            margin-top: -52px;
                width: 7%;
    height: auto;
        }
    </style>
</head>
<body ng-app="validationApp">

<div class="container" ng-controller="mainController">
<div id="page-wrap" style="display: none;">
    <img id="impala" src="./Assets/Images/impalaorig.gif">
    <h1 id="title"><b>LOG IN TO START RIDING...</b></h1>
    <form id="mainform" name="userForm" action="formlogin.php"  class="form-horizontal" method="POST"  novalidate>
        <div class="inner-addon left-addon" id="user" ng-class="{ 'has-error' : userForm.email.$invalid && !userForm.email.$pristine }">
            <i class="glyphicon glyphicon-user"></i>
            <input  type="email" class="form-control" placeholder = "Email" id="email" name="email" ng-model="user.email"/>
            <p ng-show="userForm.email.$invalid && !userForm.email.$pristine" class="help-block inv">ENTER A VALID EMAIL.</p>
        </div>
        <div class="inner-addon left-addon" id="pass">
            <i class="glyphicon glyphicon-lock"></i>
            <input type="password" class="form-control" placeholder = "Password" id="password" name="password"/>
        </div>
        <input ng-hide="true" name="lat" id="mylat"/>
        <input ng-hide="true" name="lng" id="mylng"/>
        <div class="form-group center inline">
            <div>
                <button type="button" class="btn" data-toggle="modal" data-target = "#myModal" id="signup"><b>DON'T HAVE AN ACCOUNT? SIGN UP.</b></button>
            </div>
            <div>
                <button type="submit" name="submit" class="btn" id="login" ><b>LOGIN</b></button>
            </div>
        </div>
    </form>
    <?php 
        if(isset($_GET['invalid']) && $_GET['invalid'] == 'f') {
            echo '<div class="alert alert-dismissable customalert" role="alert" id="alertcred">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              INVALID USERNAME AND/OR PASSWORD.
            </div>';
        }
    ?>
</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title nobord">GET STARTED WITH <span class="bold">IMPALA</span>!</h4>
            </div>
            <div class="modal-body">
                <p class="nobord">Enter your basic information and start riding.</p>

                <form name="registerForm"  action="formlogin.php" class="form-horizontal" method="post">
                    <div class="inner-addon left-addon" id="user" ng-class="{ 'has-error' : registerForm.first_name.$invalid && !registerForm.first_name.$pristine }">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" class="form-control nobord" name="first_name" ng-model="user.first_name" placeholder = "Enter your First Name" required/>
                        <p ng-show="registerForm.first_name.$invalid && !registerForm.first_name.$pristine" class="help-block">Your first name is required.</p>
                    </div>
                    <div class="inner-addon left-addon" id="user" ng-class="{ 'has-error' : registerForm.last_name.$invalid && !registerForm.last_name.$pristine }">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" class="form-control nobord" name="last_name" ng-model="user.last_name" placeholder = "Enter your Last Name" required/>
                        <p ng-show="registerForm.last_name.$invalid && !registerForm.last_name.$pristine" class="help-block">Your last name is required.</p>
                    </div>
                    <div class="inner-addon left-addon" id="user" ng-class="{ 'has-error' : registerForm.r_email.$invalid && !registerForm.r_email.$pristine }">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="email" class="form-control nobord" name="r_email" ng-model="user.r_email" placeholder = "Enter your email" required/>
                        <p ng-show="registerForm.r_email.$invalid && !registerForm.r_email.$pristine" class="help-block">A valid email is required.</p>
                    </div>
                    <div class="inner-addon left-addon" id="pass">
                        <i class="glyphicon glyphicon-lock"></i>
                        <input type="password" class="form-control nobord" name="r_password" ng-model="user.r_password" placeholder = "Choose a password"/>
                    </div>
                    <div class="inner-addon left-addon" id="pass" ng-class="{ 'has-error' : user.r_password != user.rc_password && !registerForm.rc_password.$pristine}">
                        <i class="glyphicon glyphicon-lock"></i>
                        <input type="password" class="form-control nobord" name="rc_password" ng-model="user.rc_password" placeholder = "Confirm password"/>
                        <p ng-show="user.r_password != user.rc_password && !registerForm.rc_password.$pristine" class="help-block">Passwords don't match.</p>
                    </div>
                    <div class="inner-addon left-addon" id="pass">
                        <i class="glyphicon glyphicon-education"></i>
                        <input type="text" class="form-control nobord" name="university" placeholder = "College/University"/>
                    </div>
                    <select name="major" class="browser-default nobord majordrop">
                        <option disabled selected value="">Major</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Liberal Arts">Liberal Arts</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Sciences">Sciences</option>
                    </select>
                    <div class="modal-footer">
                        <button type="submit" class="btn nobord" id="submit"><b>REGISTER</b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
    var QueryString = function () {
      // This function is anonymous, is executed immediately and 
      // the return value is assigned to QueryString!
      var query_string = {};
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
    $(document).ready(function() {
        if(QueryString.invalid == 'f') {
            $('#page-wrap').delay(0).fadeIn(0);
            setTimeout(function(){ $( "#mainform" ).effect( "shake" ); }, 100);
        } else {
            $('#page-wrap').delay(0).fadeIn(500);
        }
    });
    
    
    $("#alertcred").animate({
        opacity: "0"
    }, 100 );
    $("#alertcred").animate({
        opacity: "0.6"
    }, 100 );

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
            var elemlat = document.getElementById("mylat");
            elemlat.value = pos.lat;
            var elemlng = document.getElementById("mylng");
            elemlng.value = pos.lng;
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