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

        $this->dataCabangModel = new DataCabangModel();

        $model = $this->dataKebunModel;

        $listAllMap = array();

        


    //     foreach ($data as $key => $value) {
    //         $file = file_get_contents("./source_geojson/".$value->nama_cabang_kebun.".geojson");
    //         $file = json_decode($file);

    //         $features = $file->features;

    //         array_push($listAllMap, $file);
    //     }
        

    //     // $kebun = $listAllMap[0]->features[0]->properties->blok; 
    //     foreach ($data as $key => $value) {
    //         $file = file_get_contents("./source_geojson/".$value->nama_cabang_kebun.".geojson");
    //         $file = json_decode($file);

    //         foreach ($listAllMap as $keys => $values) {
    //             $kode_kebun = $values[$key]->features[$keys]->properties->blok_sap; 
    //             $data = $model->where('blok_sap', $kode_kebun)
    //             ->where('kebun', 'SENA')
    //             ->first();
            
    //             if($data)
    //             {
    //                 $features[$key]->properties->total_poko = $data->total_poko;
    //             }
    //         }
    //     }

    //     dd($kebun);

    //     // print_r($nilaiMax);exit();

    //     // dd($features);

    //     $data = [
    //         'data' => $listAllMap,
    //     ];

    //     return view('admin/Fitur/fileInti/maps',$data);

    $file = file_get_contents("./source_geojson/kamu.geojson");
    $file = json_decode($file);

    // $file = file_get_contents("./source_geojson/SenaKaretAtas_OSS.json");
    // $file = json_decode($file);

    $features = $file->features;

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

    // dd($features);

    $nilaiMax = $model->select('MAX(total_poko) AS total_poko')->where('kebun', 'SENA')->first()->total_poko;

    // print_r($nilaiMax);exit();

    // dd($features);

    $data = [
        'data' => $features,
        'nilaiMax' => $nilaiMax
    ];

    return view('admin/Fitur/fileInti/maps',$data);

    }

    public function tampilDataCabang($id){
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

        foreach ($features as $index=>$features) {
            $kode_kebun = $features->properties->blok_sap;

        }

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
