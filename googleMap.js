function loadMap(){
    var clinic = {lat: 54.352398, lng: 18.647593};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: clinic
    });
    var marker = new google.maps.Marker({
        position: clinic,
        map: map
    });
}