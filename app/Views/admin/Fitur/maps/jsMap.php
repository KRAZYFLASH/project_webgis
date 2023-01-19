<script>
        var data = <?= json_encode($data) ?>;
        var nilaiMax = <?= $nilaiMax ?>;

        var map = L.map('maps').setView({ lat : 0.0000, lon : 102.0000 }, 7);

        function getColor(d) {
		return d > (nilaiMax/8)*7 ? '#800026' :
           d > (nilaiMax/8)*6  ? '#BD0026' :
           d > (nilaiMax/8)*5  ? '#E31A1C' :
           d > (nilaiMax/8)*4  ? '#FC4E2A' :
           d > (nilaiMax/8)*3   ? '#FD8D3C' :
           d > (nilaiMax/8)*2   ? '#FEB24C' :
           d > (nilaiMax/8)*1   ? '#FED976' :
                    '#FFEDA0';
    }

    function style(feature){
        return{
            weight : 2,
            opacity : 1,
            color : 'white',
            dashArray : '3',
            fillOpacity : 0.7,
            fillColor : getColor(parseInt(feature.properties.total_poko))
        };
    }

    function onEachFeature(feature, layer)
    {
        layer.bindPopup("<h4>Info : </h4><br>"+ "Jumlah Pohon : " + feature.properties.total_poko+" <br> ");
    }
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);

        var geojson = L.geoJson(data, {
        style : style,
        onEachFeature : onEachFeature
    }).addTo(map);
</script>