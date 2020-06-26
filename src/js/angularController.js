(function() {

	var headerController = function($scope, $location, $element) {
		$scope.isActive = function(viewLocation) {
			var retVal = viewLocation === "/" ? $location.path() === viewLocation : $location.path().indexOf(viewLocation) === 0;
			return retVal;
		};

		$scope.$on('$routeChangeSuccess', function(event, current, previous) {
			if (current.pagetitle === undefined) current.pagetitle = "Julian Kolb | Kamera & Motiondesign";
			var titlePre = "Julian Kolb | "; 
			if (current.pagetitle.startsWith('paramsalbum')){
				document.getElementById('mobile_pagetitle').innerText = current.params.album.substring(1);
				if (current.pagetitle.endsWith("Foto")) document.title = titlePre + "Fotografie: " + current.params.album.substring(1); 
				else if (current.pagetitle.endsWith("Film")) document.title = titlePre + "Film: " + current.params.album.substring(1); 
			} else {
				if (current.pagetitle.startsWith(titlePre)){
					document.getElementById('mobile_pagetitle').innerText = "Julian Kolb";
					document.title = current.pagetitle;
				} 
				else{
					document.getElementById('mobile_pagetitle').innerText = current.pagetitle;
					document.title = titlePre + current.pagetitle;
				}
			}
			if (!document.getElementById('mobile_titlebar').classList.contains('closedmenu')) toggleMobileMenu();
		});    
	};

	angular.module('kolbFotografie').controller('HeaderController', headerController);



	var pictureMapController = function($scope, $location, $element) {

		var tooltip = document.getElementById("country_tooltip");

		$scope.changeLocation = function(cName) {
			$location.path("/fotografie/:" + cName);
		};

		$scope.mouseOver = function(event, cName) {
			tooltip.innerText = cName;
			tooltip.classList.add("show");
			var element = event.currentTarget;
			element.style.fill = "#BFBFBF";
		};

		$scope.mouseOut = function(event) {
			tooltip.classList.remove("show");
			var element = event.currentTarget;
			element.style.fill = "#828180";
		};


	};

	angular.module('kolbFotografie').controller('pictureMapController', pictureMapController);

	var pictureController = function($scope, $element) {
		$scope.slideIndex = 0;
		$scope.isMoving=false;
		var elems = $element[0].getElementsByClassName("slideshow_pic");
		var loaderElems = $element[0].getElementsByClassName("loader");
		showDivs(0,0);
		lazyLoad(0);

		$(document).bind('keydown', function(event) {
			switch (event.which) {
				case 37: // left
					plusDivs(-1);
					break;

				case 39: // right
					plusDivs(1);
					break;

				default:
					return; 
			}
		});

		$(document).bind('mousewheel', function(event) {
			if ($scope.isMoving) return;
			navigateTo(event.originalEvent.wheelDelta >= 0 ? -1 : 1);
		});

//    $( "div#slideshow_container").on( "swipeleft", plusDivs(1) );
//    $( "div#slideshow_container").on( "swiperight", plusDivs(-1) );

		$scope.changePicture = function(event) {
			var element = event.currentTarget;
			var rect = element.getBoundingClientRect();
			var x = (event.pageX - rect.left) / element.scrollWidth * 100;
			if (x < 50) {
				plusDivs(-1);
			} else {
				plusDivs(1);
			}
		};

		$scope.cursorChanger = function(event) {
			var element = event.currentTarget;
			var rect = element.getBoundingClientRect();
			var x = (event.pageX - rect.left) / element.scrollWidth * 100;

			if (x < 50) {
				element.style.cursor = "url(img/arrow_left.cur), pointer";
			} else {
				element.style.cursor = "url(img/arrow_right.cur), pointer";
			}
		};

		function navigateTo(n){
			$scope.isMoving = true;
			plusDivs(n);
			setTimeout(function() {
				$scope.isMoving = false;
			},500);
		}

		function showDivs(currentPic, newPic) {
			var i;
			if (elems.length > 0) {
				if (newPic >= elems.length) {
					$scope.slideIndex = 0;
				}
				if (newPic < 0) {
					$scope.slideIndex = elems.length-1;
				}
				
				elems[currentPic].parentElement.classList.remove("show");
				forceLoad($scope.slideIndex);
				elems[$scope.slideIndex].parentElement.classList.add("show");
			}
		}

		function plusDivs(n) {
			showDivs($scope.slideIndex, $scope.slideIndex += n);
		}

		function lazyLoad(n) {
			if (elems[n].getAttribute('data-src') != null){
				$(elems[n]).one("load", function() {
					elems[n].removeAttribute('data-src');
					loaderElems[n].classList.add("global_hide");
					elems[n].classList.remove("hide_pic");
					if (n < elems.length-1) lazyLoad(n+1);
				}).attr("src", elems[n].getAttribute('data-src'));
			} else if (n < elems.length-1) lazyLoad(n+1);
		}

		function forceLoad(n){
			if (elems[n].getAttribute('data-src') != null){
				$(elems[n]).one("load", function() {
					elems[n].removeAttribute('data-src');
					loaderElems[n].classList.add("global_hide");
					elems[n].classList.remove("hide_pic");
				}).attr("src", elems[n].getAttribute('data-src'));
			}
		}
	};

	angular.module('kolbFotografie').controller('PictureController', pictureController);
}());