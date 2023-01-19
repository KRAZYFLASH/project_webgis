<?= $this->extend('/admin/Fitur/fileInti/maps') ?>

<?= $this->section('dataMaps') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css">

<div class="dataPeta">
    <div class="content">
        <div class="row">
            <div class="col-5">
                <div class="card bg-gradient-primary">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Map
                        </h3>
                        <!-- card tools -->
                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm daterange"
                                title="Date range">
                                <i class="far fa-calendar-alt"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body">
                        <div id="vmap" style="height: 250px; width: 100%;"></div>
                    </div>
                    <!-- /.card-body-->
                    <div class="card-footer bg-transparent">
                        <div class="row">
                            <div class="col-4 text-center">
                                <div id="sparkline-1"></div>
                                <div class="text-white">Visitors</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4 text-center">
                                <div id="sparkline-2"></div>
                                <div class="text-white">Online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4 text-center">
                                <div id="sparkline-3"></div>
                                <div class="text-white">Sales</div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <div class="col-6 offset-1">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Files</h3>
                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Info</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    <td>kebun</td>
                                    <td><?= $data->kebun ?></td>
                                </tr>
                                <tr>
                                    <td>Blok</td>
                                    <td><?= $data->blok_sap ?></td>
                                </tr>
                                <tr>
                                    <td>Komoditi</td>
                                    <td><?= $data->komoditi ?></td>
                                </tr>
                                <tr>
                                    <td>Luas</td>
                                    <td><?= $data->luas_ha ?></td>
                                </tr>
                                <tr>
                                    <td>Total Pohon</td>
                                    <td><?= $data->total_poko ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        var data = <?= json_encode($dataz) ?>;
        var nilaiMax = <?= $nilaiMax ?>;
        var dataz = <?= $data2 ?>;

        var map = L.map('vmap').setView({ lat : -3.584166666666667, lon : 103.07694444444444 }, 11);

        function getColor(d,e) {
		return d == e ? '#ff0018' :
                    '#ffff';
    }

    function style(feature){
        return{
            weight : 2,
            opacity : 0.4,
            color : 'black',
            dashArray : '3',
            fillOpacity : 0.7,
            fillColor : getColor(feature.properties.fid_1,dataz)
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

    document.getElementById("siuu").innerHTML = geojson;


</script>

<?= $this->endSection() ?> 