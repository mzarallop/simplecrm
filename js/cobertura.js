
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: -33.4718999, lng: -70.9100242}
  });
  setMarkers(map);
}
var data = capsula({path:'clientes/ajax'})
	data = JSON.parse(data.fuente)
// Data for the markers consisting of a name, a LatLng and a zIndex for the
// order in which these markers should display on top of each other.
var beaches = data

function setMarkers(map) {
  // Adds markers to the map.

  // Marker sizes are expressed as a Size of X,Y where the origin of the image
  // (0,0) is located in the top left of the image.

  // Origins, anchor positions and coordinates of the marker increase in the X
  // direction to the right and in the Y direction down.
  var image = {
    url: 'img/estrella.png',
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(30, 30),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.

  for (var i = 0; i < 10; i++) {
    var beach = beaches[i];
    console.log(beach)
    var marker = new google.maps.Marker({
      position: {lat: parseFloat(beach.LATITUD), lng: parseFloat(beach.LONGITUD)},
      map: map,
      title: beach.NOMBRE,
      zIndex: i
    });
  }
}