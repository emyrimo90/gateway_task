let pusher = null;
let socketId = null;
var map = undefined;
var marker = undefined;
var position = [43, -89];

pusher = new Pusher(pusherKey, {
    cluster: "eu",
    forceTLS: true,
    authEndpoint: `${baseURL}/broadcasting/auth`,
    auth: {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
        }
    }
});

pusher.subscribe('drivers-locations');

pusher.bind('new.location', function (data) {
    if(data.driver.id == order.driver_id){
       var result = [parseFloat(data.driver.lat), parseFloat(data.driver.lng)];
       console.log(result);
        transition(result);
    }
});

function initMap() {
    var latlng = new google.maps.LatLng(order.driver.lat, order.driver.lng);
    var myOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map"), myOptions);

    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: "Your current location!"
    });

    google.maps.event.addListener(map, 'click', function(me) {
        var result = [me.latLng.lat(), me.latLng.lng()];
        transition(result);
    });
}

var numDeltas = 100;
var delay = 10; //milliseconds
var i = 0;
var deltaLat;
var deltaLng;

function transition(result){
    i = 0;
    deltaLat = (result[0] - position[0])/numDeltas;
    deltaLng = (result[1] - position[1])/numDeltas;
    moveMarker();
}

function moveMarker(){
    position[0] += deltaLat;
    position[1] += deltaLng;
    var latlng = new google.maps.LatLng(position[0], position[1]);
    marker.setPosition(latlng);
    if(i!=numDeltas){
        i++;
        setTimeout(moveMarker, delay);
    }
}

