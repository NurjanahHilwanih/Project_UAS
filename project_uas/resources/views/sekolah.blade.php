<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">
    <link href={{ asset('assets/css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('assets/css/bootstrap-icons.css') }} rel="stylesheet">
    <link href={{ asset('assets/css/templatemo-topic-listing.css') }} rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map {
            height: 500px;
        }

        nav.navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
            background-color:rgb(43, 88, 209);

        }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
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

        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const kabkotas = {!! json_encode($kabkotas) !!}


        const dataKabkota = kabkotas.map(kabkota => ({
            type : "Feature",
            properties:{
                name : kabkota.name,
                sekolah_sma : kabkota.sekolah_sma,
            },
            geometry: {
                type : kabkota.type_polygon,
                coordinates : JSON.parse(kabkota.polygon),
            }
        }));

        console.log(dataKabkota);

        const geoJson = {
            type : "FeatureCollection",
            features : dataKabkota,
        };

        const info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };

        info.update = function (props) {
            const contents = props ? `<b>${props.name}</b><br />${props.sekolah_sma} Sekolah SMA Negeri dan Swasta ` : 'Hover over a regency';
            this._div.innerHTML = `<h4>Jumlah Sekolah SMA Negeri & Swasta Kab/Kota Sumatera Barat</h4>${contents}`;
        };

        info.addTo(map);

        function getColor(d) {
    return d > 130 ? '#004d00' :  // Rentang 130 ke atas (hijau gelap)
           d > 110 ? '#198c19' :  // Rentang 110-130 (hijau sedang)
           d > 90  ? '#33cc33' :  // Rentang 90-110 (hijau cerah)
           d > 70  ? '#80e680' :  // Rentang 70-90 (hijau pucat)
           d > 50  ? '#ffffcc' :  // Rentang 50-70 (kuning muda)
           d > 30  ? '#ffb366' :  // Rentang 30-50 (oranye terang)
           d > 10  ? '#cc6600' :  // Rentang 10-30 (cokelat terang)
                     '#663300';   // Rentang di bawah 10 (cokelat gelap)
}

        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(feature.properties.sekolah_sma)
            };
        }

        function highlightFeature(e) {
            const layer = e.target;

            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });

            layer.bringToFront();

            info.update(layer.feature.properties);
        }

        var geojson = L.geoJson(geoJson, {
            style: style,
            onEachFeature: function (feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }
        }).addTo(map);

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }


        const legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {

            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 10, 30, 50, 70, 90, 110, 130];
            const labels = [];
            let from, to;


            for (let i = 0; i < grades.length; i++) {
                from = grades[i];
                to = grades[i + 1];

                labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
            }

            div.innerHTML = labels.join('<br>');
            return div;
        };

        legend.addTo(map);
    </script>
</body>

</html>