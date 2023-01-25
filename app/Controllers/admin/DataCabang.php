<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DataCabangModel;
use App\Models\DataKebunModel;

class DataCabang extends BaseController
{
    function __construct()
    {
        $this->dataCabangModel = new DataCabangModel();
        $this->dataKebunModel = new DataKebunModel();
    }

    public function index()
    {
        $data = [
            'data' => $this->dataCabangModel->findAll()
        ];

        return view('admin/fitur/dataCabang/dataCabang', $data);
    }

    public function create()
    {
        $data = [
            'data' => $this->dataCabangModel->findAll()
        ];

        return view('admin/fitur/dataCabang/create', $data);
    }

    public function delete($id){
        $this->dataCabangModel->delete($id);
        return redirect()->to('/dataCabang');
    }

    public function store()
    {
		$this->dataCabangModel->save([
            'nama_cabang_kebun' => $this->request->getPost('nama_cabang_kebun'),
		]);
        
        return redirect()->to('/dataCabang');
    }

    public function exportData($id)
    {
        $arr = array();
        
        $kebun = strtolower($id);

        $file = file_get_contents("./source_geojson/".$kebun.".geojson");
        $file = json_decode($file);

        header('Content-Type: application/geojson');
        header("Content-Disposition: attachment; filename= ".$kebun.".geojson");
    }
}
