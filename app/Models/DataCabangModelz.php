<?php

namespace App\Models;

use CodeIgniter\Model;

class DataCabangModel extends Model
{
    protected $table            = 'data_cabang';
    protected $primaryKey       = 'idDaerah';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['namaDaerah','file','file_dbf'];
    protected $returnType       = 'object';

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
