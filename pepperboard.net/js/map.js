function initMap() {
  var uluru = {lat: {{$report[0]->report->location->location_latitute}}, lng: {{$report[0]->report->location->location_longitute}}};
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: uluru,
      zoomControl: false,
  });
  var marker = new google.maps.Marker({
    position: uluru,
    map: map
  });
}