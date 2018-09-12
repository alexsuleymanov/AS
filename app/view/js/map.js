function initMap() {
    $("#map-block").height($("#map-wrapper").height());	// Set Map Height
    var myLatLng = new google.maps.LatLng(49.9876801,36.2187427);
    var mapOptions = {
        zoom: 17,
        center: myLatLng,
        disableDefaultUI: true
    };
    var map = new google.maps.Map(document.getElementById('map-block'), mapOptions);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: ''
    });
}
