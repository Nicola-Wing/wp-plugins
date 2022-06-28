function initSingleMap() {
    const uluru = {
        lat: Number(jQuery('#lat').val()),
        lng: Number(jQuery('#lng').val()),
    };
    const map = new google.maps.Map(document.getElementById("shop"), {
        zoom: 13,
        center: uluru,
    });
    const contentString =
        '<div id="content">' +
        '<div id="siteNotice">' +
        "</div>" +
        '<h1 id="firstHeading" class="firstHeading">' + jQuery('#title').val() + '</h1>' +
        '<div id="bodyContent">' +
        "<p>" + jQuery('#content').val() + "</p>" +
        "<p>" + jQuery('#address').val() + "</p>" +
        "</div>" +
        "</div>";
    const infowindow = new google.maps.InfoWindow({
        content: contentString,
    });
    const marker = new google.maps.Marker({
        position: uluru,
        map,
        title: "Uluru (Ayers Rock)",
    });
    marker.addListener("click", () => {
        infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
        });
    });
}