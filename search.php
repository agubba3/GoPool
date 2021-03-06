<?php
require 'base.php';
if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header('Location: index.php');
} 
?>
<!DOCTYPE html>
<html ng-app="plunker">   
    <head>
        <meta charset="utf-8" />
        <title>Impala</title>
		<link rel="shortcut icon" href="./Assets/Images/impala.gif"> 
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link href="http://bxslider.com/lib/jquery.bxslider.css" rel="stylesheet" />
		<link href="http://ricostacruz.com/nprogress/nprogress.css" rel="stylesheet" />
        <script src="http://bxslider.com/lib/jquery.bxslider.js"></script>
        <script src="http://code.angularjs.org/1.2.3/angular.js"></script>
		<script src="http://ricostacruz.com/nprogress/nprogress.js"></script>
        <script src="app.js"></script>
		<link rel="stylesheet" type="text/css" href="./Assets/apicss.css">
    </head>    
    <body ng-cloak class="ng-cloak">
        <div id="map-canvas"></div>
        <div id="map-canvas-new"></div>
		<div id="cf" class="container-fluid">
			<div class="row">
				<div id="welcomediv">
					<a href='logout.php'><button class="btn" id="logoutbutton"><span class="boldsmaller">LOGOUT</span></button></a>
					<?php 
						echo "<p id='welcome'>WELCOME, ".$_SESSION["first"]."</p>";
					 ?>	
				</div>
				<h2 id="title"><b>CHOOSE FROM POPULAR DESTINATIONS BY CATEGORY...</b></h2>
			</div>
			<div id="tabsdiv" >
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" class="tab" id="resttab">RESTAURANT<i class="glyphicon glyphicon-cutlery"></i> </a></li>
					<li role="presentation" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" class="tab">ENTERTAINMENT<i class="glyphicon glyphicon-glass"></i></a></li>
					<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" class="tab">GROCERY<i class="glyphicon glyphicon-apple"></i></a></li>
					<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" class="tab">SHOPPING<i class="glyphicon glyphicon-shopping-cart"></i></a></li>
					<li role="presentation"><a href="#travel" aria-controls="travel" role="tab" data-toggle="tab" class="tab">TRAVEL<i class="glyphicon glyphicon-plane"></i></a></li>
					<li role="presentation"><a href="#conveniece" aria-controls="convenience" role="tab" data-toggle="tab" class="tab">CONVENIENCE<i class="glyphicon glyphicon-road"></i></a></li>
					<li role="presentation"><a href="#care" aria-controls="care" role="tab" data-toggle="tab" class="tab">CARE<i class="glyphicon glyphicon-plus"></i></a></li>
				</ul>
				<div class="tab-content" ng-cloak class="ng-cloak">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div data-ng-controller="BoxController" class="whole" id="whole">
							<ul class="bxslider" data-bx-slider="mode: 'horizontal', pager: true, adaptiveHeight: true, responsive: true, auto: true, autoStart: false, controls: true, minSlides: 1, maxSlides:4, slideWidth: 325, slideMargin:5" style="padding: 0;"  ng-hide=stillloading>
								<li data-ng-repeat="place in places" data-notify-when-repeat-finished score-class >
									{{pic(place.place_id)}} 
									<div class="media">
										<div class="row {{place.borderclass}}" id="whole">
											<img id="rpic1" class="center-block bord img-responsive" src="{{place.piclink}}" alt="PHOTO NOT AVAILABLE" />
											<div class="center-block bordblock" >
												<p class="white">.</p>
												<p class="bordblocktexts {{format(place)}} text-uppercase">{{place.name}}</p>
												<p class="bordblocktexts {{scoreClass(place)}}" id="hours1">{{time(place)}}</p> 
												<p class="white">.</p>                     
											</div>
											<div class="buttondiv clicked">
											<button class="gobutton btn btn-block" id="btn1"><span class="bold">CARPOOL HERE</span></button>                      
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>	
			</div>
			<div id="line"></div>	
			<div class="input-group enterdest" ng-controller="alternatesearch">
						<input type="text" class="form-control" ng-model="inputaddress" placeholder="...OR Enter your Destination Address" name="name" id="name">
						<div class="input-group-btn">
							<button ng-click="calladdress()" class="btn " type="submit" id="find"><i class="glyphicon glyphicon-search" id="glpy"></i></button>
						</div>
			</div>
		</div> 
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Wait, hold up!</h4>
					</div>
					<div class="modal-body">
						<p>This place is closed. Are you sure you want to carpool here?</p>
					</div>      
					<div class="modal-footer">
						<button type="button" class="btn btn-success" id="goto"><b>Contine Anyways</b></button>
					</div>
				</div>
			</div>
		</div>
    </body>
</html>