<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DataCabangModel;
use App\Models\DataKebunModel;
use App\Models\DataTapiModel;

class Maps extends BaseController
{
    function __construct()
    {
        $this->dataCabangModel = new DataCabangModel();
        $this->dataKebunModel = new DataKebunModel();
        $this->dataTapiModel = new DataTapiModel();
    }

    public function index()
    {

        // $data = $this->dataCabangModel->findAll();
        // $model = $this->dataKebunModel;

        $model = $this->dataKebunModel;
        $kebun = $this->dataCabangModel;

        $listAllMap = array();
        $dataKebun = array();

        $ambilNamaData = $this->dataCabangModel->findAll();

        for ($i=0; $i < count($ambilNamaData); $i++) { 
            array_push($listAllMap , strtolower($ambilNamaData[$i]->nama_cabang_kebun));
        } // ['sena','tapi']

        for ($i=0; $i < count($listAllMap); $i++) { 
            $file = file_get_contents("./source_geojson/".$listAllMap[$i].".geojson");
            $file = json_decode($file);

            $features = $file->features;

            // dd($features);
    
            foreach ($features as $index => $feature) {
                $kode_kebun = $feature->properties->blok_sap;
                $data = $model->where('blok_sap', $kode_kebun)
                ->where('kebun', $feature->properties->kebun)
                ->first();
            
                if($data)
                {
                    $features[$index]->properties->total_poko = $data->total_poko;
                }
            }
            array_push($dataKebun , $features);
        }

        $potongan1 = "select max(total_poko) from (select * from data_".$listAllMap[0]."";
        // SELECT max(total_poko) FROM (SELECT * FROM data_sena UNION SELECT * FROM data_tapi) as siuu

        $kumpulQuery = array();

        for ($i=1; $i < count($listAllMap); $i++) { 
            array_push($kumpulQuery , " union select * from data_".$listAllMap[$i]." ");
        }

        $fileName2_potongan = implode('', $kumpulQuery);

        $hasilAkhir = $potongan1.''.$fileName2_potongan.') as siuu';
        
        $hasil = $kebun->query($hasilAkhir)->getResult();
        $nilaiMax = $hasil[0]->max;

        // dd($dataKebun);

        // $nilaiMax = $model->select('MAX(total_poko) AS total_poko')->where('kebun', 'SENA')->first()->total_poko;

        // print_r($nilaiMax);exit();

        // dd($features);

        $data = [
            'data' => $dataKebun,
            'nilaiMax' => $nilaiMax
        ];

        return view('admin/Fitur/fileInti/maps',$data);

    }

    public function tampilDataCabang($id)
    {
        // $data = $this->dataCabangModel->findColumn('file');
        $data2 = $this->dataCabangModel->asObject()->where('idDaerah', $id)->findAll();
        //SELECT file FROM `data_cabang` WHERE idDaerah = 8;

        //buat ngambil data berupa string
        $filename = $data2[0]->file;
        $file_dbf = $data2[0]->file_dbf;

        $file_excel = base_url("./source_dbf/".$file_dbf."");

        // dd($file_excel);

        $file = file_get_contents("./source_geojson/".$filename."");
		$file = json_decode($file);

		$features = $file->features;

        // foreach ($features as $index=>$features) {
        //     $kode_kebun = $features->properties->blok_sap;

        // }

        $nilaiMax = $data2->select('MAX(total_poko) as pohon');

        // dd($nilaiMax);

        $data = [
            'data' => $features,
        ];

        // dd($features);

        // $data2 = $this->dataCabangModel->findAll();


        return view('/admin/Fitur/fileInti/maps', $data);
    }

    private function getAllMap()
    {
        return view('/maps');
    }
    
}
