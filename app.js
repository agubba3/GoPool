var app = angular.module('plunker', []);

app.controller('alternatesearch',['$scope', function($scope) {
		//ng model was not working/updating	
        $(document).ready(function() {
          function map(val) {
              // var b = document.getElementById('name').value;
              val = val.replace(/ /g,'');
              url = './directions.php?name=' + val;
              document.location.href = url;
          }
          $("#find").click(
          function() {
              var b = document.getElementById('name').value;
              map(b);
          });
           $('#name').keypress(function (e) {
             var key = e.which;
             if(key == 13)  // the enter key code
              {
                  var b = document.getElementById('name').value;
                  map(b);
              }
          }); 
      });
		
}]);

app.controller('BoxController', ['$scope', '$timeout', function ($scope, $timeout) {
		NProgress.start();
		
		$scope.stillloading = true;
		// window.onload = function () { $scope.stillloading = false; } //no longer loading
		
		// function initMap() {
		
		// // Try HTML5 geolocation.
		// if (navigator.geolocation) {
		// 	navigator.geolocation.getCurrentPosition(function(position) {
		// 	var pos = {
		// 		lat: position.coords.latitude,
		// 		lng: position.coords.longitude
		// 	};
		// 	console.log(pos);
		// 	}, function() {
		// 	handleLocationError(true, infoWindow, map.getCenter());
		// 	});
		// } else {
		// 	// Browser doesn't support Geolocation
		// 	handleLocationError(false, infoWindow, map.getCenter());
		// }
		// }
		
		// function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		// infoWindow.setPosition(pos);
		// infoWindow.setContent(browserHasGeolocation ?
		// 						'Error: The Geolocation service failed.' :
		// 						'Error: Your browser doesn\'t support geolocation.');
		// }

		var autocomplete;
		function initialize(types) {
			//atlanta - 33.7550, -84.3900
						//NY - 40.7127, -74.0059
			var pyrmont = new google.maps.LatLng(33.7550, -84.3900); //INPUT USER LOCATION HERE
			
			autocomplete = new google.maps.places.Autocomplete(
				/** @type {HTMLInputElement} */(document.getElementById('name')),
				{ types: ['geocode'] });
			// When the user selects an address from the dropdown,
			// populate the address fields in the form.
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				fillInAddress();
			});
			
			var map = new google.maps.Map(document.getElementById('map-canvas'), {
				center: pyrmont,
				zoom: 15
			});
			$("#map-canvas").hide();
			var request = {
				location: pyrmont,
				radius: 500,
				types: types
			};
			var requestdetails = {
				placeId: 'ChIJN1t_tDeuEmsRUsoyG83frY4'
			};
			var infowindow = new google.maps.InfoWindow();
			var service = new google.maps.places.PlacesService(map);
			service.nearbySearch(request, callback);
		}
	
		function callback(results, status) {
			console.log(results);
			$scope.$apply(function() {
				var placess = [];
				for (var i = 0; i < results.length; i++) {
					var place = results[i];
					place.piclink = 'http://www.munkytradingco.com/wp-content/uploads/2014/04/placeholder3.png';
					place.id = i + 1;
					if(i != 0 && (i % 3 == 0)) {
						place.borderclass = 'specialrect';
					} else {
						place.borderclass = 'rect';					
					}
					placess.push(place);
				}
				$scope.places = placess;
				$scope.placestemp = placess;
			});	
		}
		var i = 0;
		var map = {};
		$scope.pic = function pic(place_id) {
			
			if(place_id in map) {
				return;
			}
			console.log('-------------------------------------------------');
			i = i + 1;
			console.log("Doing " + i + " " + place_id + i);
			var mapr = new google.maps.Map(document.getElementById('map-canvas-new'), {
				center: new google.maps.LatLng(0, 0), //irrevalent
				zoom: 15
			});
			var request = {
				placeId: place_id
			};
			var servicer = new google.maps.places.PlacesService(mapr);
			servicer.getDetails(request, function(place, status) {
				if (status == google.maps.places.PlacesServiceStatus.OK) {
					var p = place.photos;
					if (p != undefined) {
						var piclink = p[0].getUrl({
							'maxWidth': 5000,
							'maxHeight': 215
						});
						map[place_id] = piclink;
						$scope.$apply(function() {
							var places = $scope.placestemp;
							console.log('Pic Link: ' + piclink);
							for (var i = 0; i < places.length; i++) {
								var p = places[i];
								if (p.place_id == place_id) {
									p.piclink = piclink;
									break;
								}
							}
						});
					} 
				} 
			});
		};	
		

		var t = window.setInterval(function(){
			// alert("Check");
			check();
		}, 200);
		
			
		function check() {
			$timeout(function() {
				var oldi = i;
				$timeout(function() {
					var currenti = i;
					console.log("Old i: " + oldi);
					console.log("New i: " + currenti);
					// alert("Here");
					if(oldi + 5 < currenti || oldi - 5 > currenti) {
						$scope.stillloading = false;
						clearInterval(t);
					}
				}, 100);
			}, 100);	
		};
		
        $(document).ready(function(){
          function scrollTrigger(elemId, callback) {
              var lastClassName = $(elemId).val();
              window.setInterval( function() {   
                 var className = $(elemId).val(); 
                  if (className !== lastClassName) {
                          setTimeout(function(){ 
                              callback(); 
                          }, 500); 
                    lastClassName = className;
                  }
              },10);
          }
          scrollTrigger("#name", function(){
            window.scrollBy(0,5000);
          });
        });
		
		$scope.time = function time(place) {
			if(place.opening_hours != undefined && place.opening_hours.open_now) {
				return "NOW OPEN";
			} else if (place.opening_hours != undefined && !place.opening_hours.open_now) {
				return "NOW CLOSED";
			} else {
				return "ALWAYS OPEN";
			}
		}
		$scope.format = function format(place) {
			if (place.name.length > 18) {
				return 'halfed';
			} else {
				return 'title';
			}
		}
		$(document).ready(function() {
			var temp = '';
			types = ['restaurant', 'bakery', 'cafe', 'food', 'meal_delivery', 'meal_takeaway']
			initialize(types);
		});
		$scope.scoreClass = function(place) {
    		if(place.opening_hours != undefined && place.opening_hours.open_now) {
				return "open";
			} else if (place.opening_hours != undefined && !place.opening_hours.open_now) {
				return "notopen";
			} else {
				return "open";
			}
		}		
		
}]);

app.directive('bxSlider', [function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            scope.$on('repeatFinished', function () {
                console.log("ngRepeat has finished");
                element.bxSlider(scope.$eval('{' + attrs.bxSlider + '}'));
				var t = window.setInterval(function(){
					if(!scope.stillloading) {
						element.startAuto();
						NProgress.done();
					}
				}, 500);
            });
        }
    }
}])
.directive('notifyWhenRepeatFinished', ['$timeout', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
					console.log("Repeat finished one");
                    scope.$emit('repeatFinished');
                });
            }
        }
    }
}])
.directive('clicked', function () {
    var linkFn = function (scope, element, attrs) {
        $(element).on('click',  function () {
			var val = scope.place.vicinity;
            val = val.replace(/ /g,'');
            url = './directions.php?name=' + val;
            if (scope.place.opening_hours !== undefined && !scope.place.opening_hours.open_now) {
             	$(element).attr("data-target", "#myModal");
                $(element).attr("data-toggle", "modal");
               	$("#goto").click(function() {
                	document.location.href=url;
          		});
             } else {
                 document.location.href = url;
             };
        });
    }
    return {
        restrict: 'C',
        link: linkFn
    }
});
