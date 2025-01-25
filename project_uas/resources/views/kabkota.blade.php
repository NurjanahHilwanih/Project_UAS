<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin=""/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
  <link href={{ asset('assets/css/bootstrap.min.css') }} rel="stylesheet">
  <link href={{ asset('assets/css/bootstrap-icons.css') }} rel="stylesheet">
  <link href={{ asset('assets/css/templatemo-topic-listing.css') }} rel="stylesheet">  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""></script>

  <style>
    #map { height: 600px; }
    nav.navbar{
      position : fixed;
      top:0;
      width: 100%;
      z-index : 1000;
      background-color:rgb(43, 88, 209);
    }
  </style>
</head>
<body id="top">

  @include('navbar')


<main style="margin-top: 90px;">
<div id="map"></div>

</main>

  <script src={{ asset('assets/js/jquery.min.js') }}></script>
  <script src={{ asset('assets/js/bootstrap.bundle.min.js') }}></script>
  <script src={{ asset('assets/js/jquery.sticky.js') }}></script>
  <script src={{ asset('assets/js/click-scroll.js') }}></script>
  <script src={{ asset('assets/js/custom.js') }}></script>

  <script>
    var map = L.map('map').setView([-7.6138524,112.4579055], 8);
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
         
         const kabkotas = {!! json_encode($kabkotas) !!}
         
  
         kabkotas.forEach(function(kabkota){
           L.marker([kabkota.latitude, kabkota.longitude]).addTo(map).bindPopup(kabkota.name)
         })
         
  </script>
</body>
</html>