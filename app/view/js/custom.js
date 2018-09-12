$(document).ready(function(){
	// Contact Map
	if ($("#map").length > 0)
	{
		var map;

		map = new GMaps({
			el: "#map",
			lat: 49.988358,
			lng: 36.232845,
			scrollwheel: false,
			zoom: 14,
			zoomControl: true,
			panControl: false,
			streetViewControl: false,
			mapTypeControl: false,
			overviewMapControl: false,
			clickable: false
		});

		var image = "";
		map.addMarker({
			lat: 49.988358,
			lng: 36.232845,
			icon: "/app/view/img/marker.png",
			animation: google.maps.Animation.DROP,
			verticalAlign: "bottom",
			horizontalAlign: "center",
			backgroundColor: "#d3cfcf"
		});

		var styles = [
			{
				"featureType": "road",
				"stylers": [
					{"color": "#ffffff"}
				]
			}, {
				"featureType": "water",
				"stylers": [
					{"color": "#f2f2f2"}
				]
			}, {
				"featureType": "landscape",
				"stylers": [
					{"color": "#f2f2f2"}
				]
			}, {
				"elementType": "labels.text.fill",
				"stylers": [
					{"color": "#2d2d2d"}
				]
			}, {
				"featureType": "poi",
				"stylers": [
					{"color": "#f2f2f2"}
				]
			}, {
				"elementType": "labels.text",
				"stylers": [
					{"saturation": 1},
					{"weight": 0.1},
					{"color": "#b1b1b1"}
				]
			}

		];

		map.addStyle({
			styledMapName: "Styled Map",
			styles: styles,
			mapTypeId: "map_style"
		});

		map.setStyle("map_style");
	}
});

(function($) {

	"use strict";

	// Product Owl Carousel
	$("#owl-product-2").owlCarousel({
		autoPlay: false, //Set AutoPlay to 3 seconds
		items : 1,
		scrollPerPage : true,
		slideBy: 1,
		stopOnHover : true,
		nav : true, // Show next and prev buttons
		pagination : false,
		navText : ["",""]
	});

})(jQuery);