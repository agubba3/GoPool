var app = angular.module('plunker', []);

app.controller('BoxController', ['$scope', function ($scope) {
		function initialize(types) {
			// 39.1833, -77.2667
			//poolesville - 39.1406, -77.4083
			//atlanta - 33.7550, -84.3900
			var pyrmont = new google.maps.LatLng(40.7127, -74.0059	); //INPUT USER LOCATION HERE
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
				var places = [];
				for (var i = 0; i < results.length; i++) {
					var place = results[i];
					place.piclink = 'http://www.munkytradingco.com/wp-content/uploads/2014/04/placeholder3.png';
					places.push(place);
				}
				$scope.places = places;
			});	
		}
		var i = 0;
		var map = {};
		$scope.pic = function pic(place_id) {
			if(place_id in map) {
				return;
			}
			console.log('-------------------------------------------------');
			// i = i + 1;
			// console.log("Doing " + i + " " + place_id + i);
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
							var places = $scope.places;
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
		}
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
        $(element).on('click', 'button', function () {
			var val = scope.place.vicinity;
            val = val.replace(/ /g,'');
            url = './directions.html?name=' + val;
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