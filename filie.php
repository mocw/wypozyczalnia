<script> // ZRODLO: https://codepen.io/albertofortes/pen/rpErwm?fbclid=IwAR3KIav0odDYm2-chBd--LGPrvINzpLwB-VPS7LM7Q6bi9wuZKy5t1el_7U
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap',
        disableDefaultUI: true
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

    // Multiple Markers
    var markers = [
        ['Lodz ul. Piotrkowska 137', 51.7615562, 19.4555721],
        ['Warszawa ul. Marszalkowska 66', 52.2250362, 21.0129091],
        ['Poznan ul. Dluga 15', 52.4038166, 16.9307126],
        ['Krakow ul. 29 listopada 155', 50.0958372, 19.9604282]
    ];

		var wonderlinks = $('[data-wonder]');
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
				wonderlinks.filter(function(){
        return $(this).data('wonder') === markers[i][0];
        }).on('click', (function(marker){
        	return function(){
        		map.panTo(marker.getPosition());
          }
        })(marker));
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                map.panTo(marker.getPosition());
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(7);
        google.maps.event.removeListener(boundsListener);
    });
}
</script>

<div id="menu2" >
<nav class="menu2">
<ul class="nav nav-pills">
    <li  class="contact-link active"><a>Łódź</a>
    <ul><li class="contact-link active"><a data-toggle="pill" data-wonder="Lodz ul. Piotrkowska 137" href="#lodz">Piotrkowska 137</a></li></ul>
    <li  class="contact-link active"><a>Warszawa</a>
    <ul><li class="contact-link"><a data-toggle="pill" data-wonder="Warszawa ul. Marszalkowska 66" href="#warszawa">Marszałkowska 66</a></li></ul>
    <li  class="contact-link active"><a>Poznań</a>
    <ul><li class="contact-link"><a data-toggle="pill" data-wonder="Poznan ul. Dluga 15" href="#poznan">Długa 15</a></li></ul>
    <li  class="contact-link active"><a>Kraków</a>
    <ul><li class="contact-link"><a data-toggle="pill" data-wonder="Krakow ul. 29 listopada 155" href="#krakow">29 listopada 155</a></li></ul>    
</ul>
</nav>
</div>
<div id="googleMap" class="mapping" style="height:550px;"></div>