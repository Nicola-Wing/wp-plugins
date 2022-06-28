function initMap() {
    var map_markers = map_data.markers;
    var map_center = new google.maps.LatLng(map_data.center[0], map_data.center[1]);
    var map_zoom = Number(map_data.zoom);
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: map_zoom,
        center: map_center,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    if (map_markers.length) {
        var infowindow = new google.maps.InfoWindow(),
            marker,
            i;
        for (i = 0; i < map_markers.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(
                    map_markers[i]['latlang'][0],
                    map_markers[i]['latlang'][1]
                ),
                title: map_markers[i]['title'],
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(map_markers[i]['desc']);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }
}
