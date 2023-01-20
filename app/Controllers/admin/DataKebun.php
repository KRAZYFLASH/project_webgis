<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DataKebunModel;
use App\Models\DataCabangModel;
use App\Models\DataSenaModel;

class DataKebun extends BaseController
{
    function __construct()
    {
        $this->dataKebunModel = new DataKebunModel();
        $this->dataCabangModel = new DataCabangModel();
        $this->dataSenaModel = new DataSenaModel();
    }

    public function index()
    {
        // $query = $this->dataKebunModel->query("select st_x(st_astext(st_GeometryN(st_centroid(geom),1))) ,st_y(st_astext(st_GeometryN(st_centroid(geom),1))) from data_kebun");
        // $geo = $query->getResult();

        $dataKebun = array();

        $ambilNamaData = $this->dataCabangModel->findAll();

        for ($i=0; $i < count($ambilNamaData); $i++) { 
            array_push($dataKebun , strtolower($ambilNamaData[$i]->nama_cabang_kebun));
        } // ['sena','tapi']


        $data = $this->dataSenaModel;
        
        $query = $data->query("select * from data_sena 
                            union select * from data_tapi");
    

        $query2 = $this->dataCabangModel->query("with tmp1 as (
            select 'Feature' as \"type\",
                ST_AsGeoJSON(t.geom,6)::json as \"geometry\",
                (
                    select json_strip_nulls(row_to_json(t))
                    from(
                        SELECT gid, layer, fid_1, kebun, afdeling, blok, blok_sap, komoditi, tahuntanam, luas_ha, total_poko, pokok_per_, varietas, ST_AsGeoJSON(ST_GeomFromText('MULTIPOLYGON(((103.135341 -3.613098,103.135412 -3.613872,103.135412 -3.614501,103.13394 -3.614501,103.13395 -3.614443,103.13399 -3.614299,103.13395 -3.614239,103.133963 -3.61407,103.134135 -3.613946,103.134304 -3.613745,103.134665 -3.613474,103.135091 -3.612928,103.135341 -3.613098)))'))
                    ) t
                ) as \"properties\"
            from public.data_kebun t
        ), tmp2 as (
                select 'FeatureCollection' as \"type\",
                    array_to_json(array_agg(t)) as \"features\"
                from tmp1 t
        
        )	select row_to_json(t)
        from tmp2 t;");

        // dd($query2);

        $geo2 = $query2->getResult();

        $isi = $geo2[0]->row_to_json;

        $file = fopen("source_geojson/kamu.geojson", "w");
        fwrite($file, $isi);
        fclose($file);


        $data = [
            'data' => $this->dataKebunModel->findAll()
        ];

        return view('admin/fitur/dataKebun/dataKebun', $data);
    }

    public function create()
    {
        $data = [
            'data' => $this->dataCabangModel->findAll()
        ];

        return view('admin/fitur/dataKebun/create', $data);
    }

    public function delete($id){
        $this->dataCabangModel->delete($id);
        return redirect()->to('/dataKebun');
    }

    public function store()
    {
        $data_dbf = $this->request->getFile('file_dbf');
        $data_geojson = $this->request->getFile('file');
		$fileName = $data_geojson->getRandomName();
        $fileName2 = $data_dbf->getRandomName();

        $simpanan = ".csv";
        $fileName2_potongan = explode('.', $fileName2);
        $ekstensiGambar = $fileName2_potongan[1];
        $fileName2_potongan[1] = $simpanan;

        $konz = implode($fileName2_potongan);

		$this->dataCabangModel->save([
            'namaDaerah' => $this->request->getPost('namaDaerah'),
			'file' => $fileName,
            'file_dbf' => $konz,
		]);
		$data_geojson->move('source_geojson/', $fileName);
        $data_dbf->move('source_dbf/', $konz);
        
        return redirect()->to('/dataKebun');
    }

    public function ambilDataKebun($id)
    {

        $this->dataCabangModel = new DataCabangModel();

        $model = $this->dataKebunModel;


		$file = file_get_contents("./source_geojson/kamu.geojson");
		$file = json_decode($file);

        // $file = file_get_contents("./source_geojson/SenaKaretAtas_OSS.json");
		// $file = json_decode($file);

		$features = $file->features;

        foreach ($features as $index => $feature) {
            $kode_kebun = $feature->properties->blok_sap;
            $dataz = $model->where('blok_sap', $kode_kebun)
            ->where('kebun', 'SENA')
            ->first();
        
            if($dataz)
            {
                $features[$index]->properties->total_poko = $dataz->total_poko;
            }
        }

        $nilaiMax = $model->select('MAX(total_poko) AS total_poko')->where('kebun', 'SENA')->first()->total_poko;

        $data = $this->dataKebunModel->find($id);
        $data2 = $data->fid_1;

        // dd($data2);
        
        $_data = [
            'data' => $data,
            'dataz' => $features,
            'data2' => $data2,
            'nilaiMax' => $nilaiMax
        ];
        
        return view('/admin/fitur/maps/data', $_data);
    }

    public function tampilDataKebun($id)
    {
        $ambil_data = $this->dataCabangModel->find($id)->nama_cabang_kebun;

        $siuu = strtolower($ambil_data);

        // dd($siuu);


        $data = $this->dataCabangModel;

        // $hasilData = $data->select('*')
        //             ->join('data_"'.$siuu.'"', 'data_cabang_kebun.nama_cabang_kebun = data_"'.$siuu.'".kebun ')
        //             ->get();

        // $datas = $data->select('*')
        //             ->join('data_sena', 'data_cabang_kebun.nama_cabang_kebun = data_sena.kebun')
        //             ->get();

        $query = $data->query("select * from data_cabang_kebun
        join data_".$siuu."
        on data_cabang_kebun.nama_cabang_kebun = data_".$siuu.".kebun;");
    
        // dd($dataj);
        
        $_data = [
            'data' => $query->getResult()
        ];
        return view('admin/fitur/dataKebun/dataKebun', $_data);
    }
}
