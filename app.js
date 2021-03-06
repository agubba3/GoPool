var app = angular.module('plunker', []);

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

app.controller('alternatesearch',['$scope', function($scope) {
		//ng model was not working/updating	
        $(document).ready(function() {
          function map(val) {
              // var b = document.getElementById('name').value;
              url = './directions.php?name=' + val + '&lat=' + QueryString.lat + '&lng=' + QueryString.lng;
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
		var autocomplete;
		function initialize(types) {
			//atlanta - 33.7550, -84.3900
			//NY - 40.7127, -74.0059
			
			var pyrmont = new google.maps.LatLng(QueryString.lat,QueryString.lng); //INPUT USER LOCATION HERE
			
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
				radius: 10000,
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
			check();
		}, 50);
		
			
		function check() {
			console.log("LOAD: " + $scope.stillloading);
			$timeout(function() {
				var oldi = i;
				$timeout(function() {
					var currenti = i;
					console.log("Old i: " + oldi);
					console.log("New i: " + currenti);
					if(Math.abs(oldi - currenti) < 5 && oldi != 0 && currenti != 0) { //Math.abs(oldi - currenti) < 5 && oldi != 0 && currenti != 0
						$scope.stillloading = false;
						console.log("LOAD SHOULD BE FALSE: " + $scope.stillloading);
						clearInterval(t);
					}
				}, 25);
			}, 25);	
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
				}, 100);
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
            // alert(val);
            url = './directions.php?name=' + val + '&lat=' + QueryString.lat + '&lng=' + QueryString.lng;
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
